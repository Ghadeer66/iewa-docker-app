<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::role('client')
            ->select('id', 'name', 'email', 'phone', 'created_at')
            ->latest()
            ->get();

        return Inertia::render('Admin/Clients', [
            'clients' => $clients
        ]);
    }
}
