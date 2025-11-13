<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $authId = Auth::id();
        $user = User::find($authId);
        $users_count = User::where('belongs_to',$authId)->count();

        // Calculate wallet stats
        $wallet = Wallet::where('user_id', $authId)->first();
        $transactionsCount = WalletTransaction::whereHas('wallet', fn($q) => $q->where('user_id', $authId))->count();

        return inertia('Business/Dashboard/Index', [
            'user' => $user,
            'stats' => [
                'users_count' => $users_count,
                'wallet_balance' => $wallet ? $wallet->balance : 0,
                'transactions_count' => $transactionsCount,
            ],
        ]);
    }


    /**
     * Update a client that belongs to the authenticated business.
     */
    public function updateClient(Request $request, User $user)
    {
        $authId = Auth::id();
        // Ensure the client belongs to this business
        if (!$user || $user->belongs_to !== $authId) {
            return back()->withErrors(['user' => 'کاربر یافت نشد یا متعلق به شما نیست']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'personal_code' => ['nullable', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
            'position' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($validated);

        return back()->with('message', 'اطلاعات کاربر با موفقیت به‌روزرسانی شد');
    }

    /**
     * Delete a client that belongs to the authenticated business.
     */
    public function destroyClient(User $user)
    {
        $authId = Auth::id();
        if (!$user || $user->belongs_to !== $authId) {
            return back()->withErrors(['user' => 'کاربر یافت نشد یا متعلق به شما نیست']);
        }

        // Option: instead of deleting, you might prefer to unassign (set belongs_to = null).
        // For now, delete the user record.
        $user->delete();

        return back()->with('message', 'کاربر حذف شد');
    }

    public function manageEmployees()
    {
        // Eager-load clients to avoid N+1 queries in the Inertia page.
        $authId = Auth::id();
        if ($authId) {
            $user = User::with(['clients' => function ($q) use ($authId) {
                $q->where('belongs_to', $authId)
                    ->select('id', 'name', 'personal_code', 'phone', 'position', 'belongs_to');
            }])->find($authId);
        } else {
            $user = null;
        }

        return inertia('Business/UsersManagenent/Index', [
            'user' => $user,
            'stats' => [
                'total_orders' => 0, // You can add your business logic here
                'pending_orders' => 0,
                'completed_orders' => 0,
                'revenue' => 0,
            ]
        ]);
    }
    public function wallet()
    {
        $userId = Auth::id();
        $wallet = Wallet::where('user_id', $userId)->first();

        $transactions = WalletTransaction::with(['wallet.user', 'receiverWallet.user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tx) {
                return [
                    'id' => $tx->id,
                    'type' => $tx->type,
                    'amount' => $tx->amount,
                    'description' => $tx->description,
                    'created_at' => $tx->created_at->format('Y-m-d H:i:s'),
                    'sender' => $tx->wallet->user ? ['name' => $tx->wallet->user->name] : null,
                    'receiver' => $tx->receiverWallet && $tx->receiverWallet->user
                        ? ['name' => $tx->receiverWallet->user->name]
                        : null,
                ];
            });



        return inertia('Business/Wallet/Index', [
            'wallet' => $wallet,
            'transactions' => $transactions,
        ]);
    }
}
