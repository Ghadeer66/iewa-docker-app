<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::latest()->get();

        return Inertia::render('Admin/Types', [
            'types' => $types
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Type::create($validated);

        return redirect()->back()->with('success', 'نوع با موفقیت افزوده شد.');
    }

    public function update(Request $request, Type $type)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $type->update($validated);

        return redirect()->back()->with('success', 'نوع با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Type $type)
    {
        $type->delete();
        return redirect()->back()->with('success', 'نوع با موفقیت حذف شد.');
    }
}
