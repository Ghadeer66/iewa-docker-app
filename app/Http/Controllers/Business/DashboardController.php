<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

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
}
