<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('name')->get();
        $roles = Role::with('permissions')->orderBy('name')->get();
        $admins = User::role('admin')->get();

        return Inertia::render('Admin/Permissions', [
            'permissions' => $permissions,
            'roles' => $roles,
            'admins' => $admins,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        Permission::create(['name' => $validated['name'], 'guard_name' => 'web']);

        return redirect()->back()->with('success', 'مجوز با موفقیت ایجاد شد.');
    }

    public function assignToRole(Request $request)
    {
        $validated = $request->validate([
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::findById($validated['role_id']);
        $permission = Permission::findById($validated['permission_id']);

        if (!$role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
            return redirect()->back()->with('success', 'مجوز با موفقیت به نقش اختصاص داده شد.');
        }

        return redirect()->back()->with('error', 'این نقش قبلاً این مجوز را دارد.');
    }

    public function revokeFromRole(Request $request)
    {
        $validated = $request->validate([
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::findById($validated['role_id']);
        $permission = Permission::findById($validated['permission_id']);

        $role->revokePermissionTo($permission);

        return redirect()->back()->with('success', 'مجوز با موفقیت از نقش حذف شد.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('success', 'مجوز با موفقیت حذف شد.');
    }
}
