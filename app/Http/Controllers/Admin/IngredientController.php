<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IngredientController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Warehouse', [
            'ingredients' => Ingredient::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
        ]);

        Ingredient::create($data);

        return redirect()->back();
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->back();
    }
}
