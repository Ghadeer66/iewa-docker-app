<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    public function index()
    {
        // Get all users with "Client" role, eager-loading their parent business
        $clients = User::role('Client')->with('parentBusiness')->get();

        // Get all users with "Business" role to list in the dropdown
        $companies = User::role('Business')->get();

        return Inertia::render('Admin/Clients', [
            'clients' => $clients,
            'companies' => $companies,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'belongs_to' => 'nullable|exists:users,id',
            'personal_code' => 'required', // Add default or random personal code
            'position' => 'required'
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'belongs_to' => $validated['belongs_to'] ?? null,
            'password' => bcrypt('password'), // default or random password
            'personal_code' => $validated['personal_code'], // Add default or random personal code
            'position' => $validated['position']
        ]);

        // Assign role via Spatie
        $user->assignRole('Client');

        return redirect()->back()->with('success', 'مشتری جدید با موفقیت اضافه شد');
    }

    public function destroy(User $client)
    {
        $client->delete();
        return redirect()->back()->with('success', 'مشتری حذف شد');
    }
}
