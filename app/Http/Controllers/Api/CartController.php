<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get all cart items for current user
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->with('meal') // eager load meal relation
            ->get()
            ->map(function ($item) {
                // Safely format date whether it's a Carbon instance or a string/null
                $dateISO = null;
                if (is_string($item->date)) {
                    $dateISO = $item->date;
                } elseif ($item->date instanceof \DateTimeInterface) {
                    $dateISO = $item->date->format('Y-m-d');
                }

                return [
                    'id' => $item->id,
                    'mealId' => $item->meal_id,
                    'mealTitle' => $item->meal->title ?? 'Unknown',
                    'mealImage' => $item->meal->image ?? null,
                    'dateISO' => $dateISO,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ];
            });

        return response()->json($cart);
    }

    // Add items to cart
    public function store(Request $request)
    {
        $request->validate([
            'mealId' => 'required|exists:meals,id',
            'dates' => 'required|array',
            'dates.*' => 'date',
        ]);

        $meal = Meal::findOrFail($request->mealId);

        foreach ($request->dates as $date) {
            // Check if item already exists
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('meal_id', $meal->id)
                ->where('date', $date)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'meal_id' => $meal->id,
                    'date' => $date,
                    'price' => $meal->price,
                    'quantity' => 1,
                ]);
            }
        }

        return response()->json(['message' => 'Added to cart']);
    }

    // Remove one quantity
    public function removeOne(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }

        return response()->json(['message' => 'Removed one item']);
    }

    // Remove all of a cart item
    public function removeAll(Request $request, $id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return response()->json(['message' => 'Removed all of this item']);
    }

    // Clear cart
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Cart cleared']);
    }
}
