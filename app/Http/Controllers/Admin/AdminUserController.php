<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Show all admins
    public function index(Request $request)
{
    // Use Spatie role method instead of whereHas
    $query = User::role('admin');

    // Apply search filter if provided
    if ($search = $request->get('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%"); // added phone search
        });
    }

    // Paginate results
    $admins = $query->paginate(10);

    return inertia('Admin/Admins', [
        'admins'  => $admins,
        'filters' => $request->only('search'),
    ]);
}



    // Store new admin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required'
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'personal_code' => '', // Add default or random personal code
            'position' => 'admin'
        ]);
        $user->assignRole('admin');

        return redirect()->back()->with('success', 'ادمین جدید با موفقیت افزوده شد.');
    }

    // Update existing admin
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'اطلاعات ادمین با موفقیت به‌روزرسانی شد.');
    }

    // Delete an admin
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'ادمین با موفقیت حذف شد.');
    }
}
