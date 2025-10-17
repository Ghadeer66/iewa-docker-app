<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'meal'])
            ->latest()
            ->get();

        return Inertia::render('Admin/Orders', [
            'orders' => $orders
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,delivered,cancelled',
            'notes' => 'nullable|string'
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'سفارش با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->back()->with('success', 'سفارش با موفقیت حذف شد.');
    }
}
