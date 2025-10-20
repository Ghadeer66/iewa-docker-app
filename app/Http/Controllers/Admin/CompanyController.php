<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        // Get all companies (users with business role) with their admin
        $companies = User::role('business')
            ->with('admin')
            ->select('id', 'name', 'email', 'business_name', 'belongs_to', 'created_at')
            ->latest()
            ->get();

        // Get all users with admin role for the dropdown
        $admins = User::role('admin')
            ->select('id', 'name')
            ->get();

        return Inertia::render('Admin/Companies', [
            'companies' => $companies,
            'admins' => $admins
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
        ]);

        // Create the company user
        $company = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt('password'), // default password, change as needed
            'phone' => $data['phone'],
            'position' => 'company', // or leave blank
            'personal_code' => uniqid(), // or generate as needed
            'business_name' => $data['business_name'],
            'belongs_to' => $data['admin_id'],

        ]);

        $company->assignRole('business');

        return redirect()->back()->with('success', 'شرکت جدید ایجاد شد.');
    }
}
