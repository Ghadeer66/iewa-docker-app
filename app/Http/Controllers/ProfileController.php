<?php

namespace App\Http\Controllers;

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
        $orders = $user->orders()->withCount('items')->latest()->get();

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

        return Inertia::render('Profile/Transactions', [
            'user' => $user,
        ]);
    }

    public function wallet()
    {
        $user = Auth::user();

        return Inertia::render('Profile/Wallet', [
            'user' => $this->getUserData($user, true),
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
