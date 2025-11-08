<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends Controller
{
    // GET /cart
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([], 200);
        }

        // Get cart items for this user and return a flat list of records
        $cart = Cart::where('user_id', $user->id)->get();

        $data = $cart->map(function ($item) {
            // Correctly load the meal with its images. Using Meal::find(...)->with(...) is wrong
            // because find() returns a model instance and calling with() on an instance
            // will start a fresh query (losing the id filter) causing the wrong meal to be returned.
            // Use the query builder with eager loading then find the specific id.
            $meal = Meal::with('images')->find($item->meal_id);

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
                'mealTitle' => $meal?->title ?? 'نامشخص',
                // Safely get the first image url (if any). Use null-safe chaining to avoid errors.
                'mealImage' => $meal?->images?->first()?->url ?? '/images/default-meals-images/ott-meal.jpg',
                'dateISO' => $dateISO,
                'price' => $item->price,
                'quantity' => $item->quantity,
            ];
        });

        return response()->json($data);
    }

    // POST /cart
    public function store(Request $request)
    {
        $request->validate([
            'mealId' => 'required|exists:meals,id',
            'dates' => 'required|array|min:1',
            'dates.*' => 'required|date_format:Y-m-d',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $userId = Auth::id();
        $meal = Meal::find($request->mealId);

        foreach ($request->dates as $date) {
            // check if this meal for this date already exists
            $exists = Cart::where('user_id', $userId)
                ->where('meal_id', $meal->id)
                ->where('date', $date)
                ->first();

            $qtyToAdd = $request->input('quantity', 1);
            if ($exists) {
                // increment existing row quantity
                $exists->quantity = ($exists->quantity ?? 0) + $qtyToAdd;
                $exists->save();
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'meal_id' => $meal->id,
                    'date' => $date,
                    'price' => $meal->price,
                    'quantity' => $qtyToAdd,
                ]);
            }
        }

        return response()->json(['message' => 'Added to cart successfully']);
    }

    // DELETE /cart/{id} - remove single item
    public function destroy(Cart $cart)
    {
        $this->authorize('delete', $cart); // optional policy

        $cart->delete();

        return response()->json(['message' => 'Item removed']);
    }

    // DELETE /cart/{id}/one - remove one quantity (or delete the item)
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

    // DELETE /cart/{id}/all - remove entire cart entry
    public function removeAll(Request $request, $id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return response()->json(['message' => 'Removed all of this item']);
    }

    // DELETE /cart - clear all
    public function clear()
    {
        $userId = Auth::id();
        Cart::where('user_id', $userId)->delete();

        return response()->json(['message' => 'Cart cleared']);
    }
}
