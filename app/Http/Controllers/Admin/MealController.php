<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::with(['types'])
            ->latest()
            ->get();

        return Inertia::render('Admin/Meals', [
            'meals' => $meals
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type_id' => 'required|exists:types,id',
            'package_id' => 'required|exists:packages,id',
            'is_active' => 'boolean'
        ]);

        Meal::create($validated);

        return redirect()->back()->with('success', 'غذا با موفقیت افزوده شد.');
    }

    public function update(Request $request, Meal $meal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type_id' => 'required|exists:types,id',
            'package_id' => 'required|exists:packages,id',
            'is_active' => 'boolean'
        ]);

        $meal->update($validated);

        return redirect()->back()->with('success', 'غذا با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();
        return redirect()->back()->with('success', 'غذا با موفقیت حذف شد.');
    }
}
