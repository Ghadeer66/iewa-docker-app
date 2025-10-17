<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = User::role('business')
            ->select('id', 'name', 'email', 'business_name', 'created_at')
            ->latest()
            ->get();

        return Inertia::render('Admin/Companies', [
            'companies' => $companies
        ]);
    }
}
