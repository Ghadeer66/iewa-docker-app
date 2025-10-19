<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
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

        return inertia('Business/Dashboard/Index', [
            'user' => $user,
            'stats' => [
                'total_orders' => 0, // You can add your business logic here
                'pending_orders' => 0,
                'completed_orders' => 0,
                'revenue' => 0,
            ]
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
}
