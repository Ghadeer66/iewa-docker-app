<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    // Remove the constructor entirely
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $user = Auth::user();

        return Inertia::render('Profile/Index', [
            'user' => $user
        ]);
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->get();

        return Inertia::render('Profile/Orders', [
            'user' => $user,
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'total_amount' => $order->total_amount ?? 0,
                    'status' => $order->status,
                    'status_text' => $this->getStatusText($order->status),
                    'created_at' => $order->created_at->format('Y/m/d H:i'),
                    'items_count' => $order->items_count,
                ];
            })
        ]);
    }

    public function addresses()
    {
        $user = Auth::user();

        return Inertia::render('Profile/Addresses', [
            'user' => $user,
        ]);
    }

    public function transactions()
    {
        $user = Auth::user();

        // Fetch user wallet (each user has one wallet)
        $wallet = Wallet::where('user_id', $user->id)->first();

        // If user has no wallet yet, return empty transactions
        if (!$wallet) {
            return inertia('Profile/Transactions', [
                'user' => $user,
                'wallet' => null,
                'transactions' => [],
            ]);
        }

        // Fetch all related transactions (either from or to this wallet)
        $transactions = WalletTransaction::with(['wallet.user', 'toWallet.user'])
            ->where(function ($query) use ($wallet) {
                $query->where('wallet_id', $wallet->id)
                    ->orWhere('to_wallet_id', $wallet->id);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tx) use ($wallet) {
                $isOutgoing = $tx->wallet_id === $wallet->id;

                return [
                    'id' => $tx->id,
                    'type' => $isOutgoing ? 'withdrawal' : 'deposit',
                    'amount' => $tx->amount,
                    'description' => $tx->description,
                    'created_at' => $tx->created_at->format('Y-m-d H:i:s'),
                    'counterparty' => $isOutgoing
                        ? optional($tx->toWallet->user)->name
                        : optional($tx->wallet->user)->name,
                ];
            });

        return inertia('Profile/Transactions', [
            'user' => $user,
            'wallet' => $wallet,
            'transactions' => $transactions,
        ]);
    }

    public function wallet()
    {
        $user = Auth::user();

        $wallet = Wallet::where('user_id', $user->id)->first();

        $transactions = WalletTransaction::with('receiverWallet')
            ->where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tx) {
                return [
                    'id' => $tx->id,
                    'type' => $tx->type,
                    'amount' => $tx->amount,
                    'description' => $tx->description,
                    'created_at' => $tx->created_at->format('Y-m-d H:i:s'),
                    'receiver' => $tx->receiverWallet ? ['name' => $tx->receiverWallet->name] : null,
                ];
            });

        return inertia('Profile/Wallet', [
            'user' => $user,
            'wallet' => $wallet,
            'transactions' => $transactions,
        ]);
    }


    public function comments()
    {
        $user = Auth::user();

        return Inertia::render('Profile/Comments', [
            'user' => $user,
            'comments' => [] // Add your comments logic here
        ]);
    }

    public function settings()
    {
        $user = Auth::user();

        return Inertia::render('Profile/Settings', [
            'user' => $user,
        ]);
    }

    private function getUserData($user, $includeWallet = false)
    {
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'personal_code' => $user->personal_code,
            'position' => $user->position,
            'avatar' => $user->avatar,
        ];

        if ($includeWallet) {
            $data['wallet_balance'] = $user->wallet_balance ?? 0;
        }

        return $data;
    }

    private function getStatusText($status)
    {
        $statuses = [
            'pending' => 'در انتظار پرداخت',
            'sent' => 'ارسال شده',
            'canceled' => 'لغو شده',
            'unpaid' => 'پرداخت نشده',
            'completed' => 'تکمیل شده'
        ];

        return $statuses[$status] ?? 'نامشخص';
    }
}
