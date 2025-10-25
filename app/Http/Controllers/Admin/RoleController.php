<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all()->map(function ($role) {
            $role->translated_name = __('roles.' . $role->name);
            return $role;
        });
        $admins = User::role('admin')->with('roles')->get();

        return Inertia::render('Admin/Roles', [
            'roles' => $roles,
            'admins' => $admins,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name'
        ]);

        Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        return redirect()->back()->with('success', 'نقش با موفقیت ایجاد شد.');
    }

    public function assignToAdmin(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($validated['user_id']);
        $role = Role::findById($validated['role_id']);

        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            return redirect()->back()->with('success', 'نقش با موفقیت به کاربر اختصاص داده شد.');
        }

        return redirect()->back()->with('error', 'این کاربر قبلاً این نقش را دارد.');
    }

    public function revokeFromAdmin(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($validated['user_id']);
        $role = Role::findById($validated['role_id']);

        $user->removeRole($role);

        return redirect()->back()->with('success', 'نقش با موفقیت از کاربر حذف شد.');
    }

    public function destroy(Role $role)
    {
        // Prevent deletion of default roles
        if (in_array($role->name, ['admin', 'business', 'user'])) {
            return redirect()->back()->with('error', 'نمی‌توان نقش پیش‌فرض را حذف کرد.');
        }

        $role->delete();
        return redirect()->back()->with('success', 'نقش با موفقیت حذف شد.');
    }
}
