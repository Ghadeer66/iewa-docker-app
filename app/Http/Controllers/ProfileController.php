<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        // $user = User::first();
        $user = User::first();
        return Inertia::render('Profile/Index', [
            'user' => $user,
        ]);
    }

    public function orders()
    {
        $user = User::first();
        $orders = $user->orders()->latest()->get();

        return Inertia::render('Profile/Orders', [
            'user' => $user,
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'status_text' => $this->getStatusText($order->status),
                    'created_at' => $order->created_at->format('Y/m/d H:i'),
                    'items_count' => $order->items_count,
                ];
            })
        ]);
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

    public function addresses()
    {
        $user = User::first();

        return Inertia::render('Profile/Addresses', [
            'user' => $this->getUserData($user),
        ]);
    }

    public function transactions()
    {
        $user = User::first();

        return Inertia::render('Profile/Transactions', [
            'user' => $this->getUserData($user),
        ]);
    }

    public function wallet()
    {
        $user = User::first();

        return Inertia::render('Profile/Wallet', [
            'user' => $this->getUserData($user, true),
        ]);
    }

    public function settings()
    {
        $user = User::first();

        return Inertia::render('Profile/Settings', [
            'user' => $this->getUserData($user),
        ]);
    }

    public function comments()
    {
        $user = User::first();

        return Inertia::render('Profile/Comments', [
            'user' => $this->getUserData($user),
            'comments' => [] // You can populate this with actual comments data
        ]);
    }

    private function getUserData($user, $includeWallet = false)
    {
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $user->avatar,
        ];

        if ($includeWallet) {
            $data['wallet_balance'] = $user->wallet_balance ?? 0;
        }

        return $data;
    }
}
