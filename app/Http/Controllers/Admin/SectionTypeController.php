<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SectionType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionTypeController extends Controller
{
    public function index()
    {
        $sectionTypes = SectionType::with('sectionElements')
            ->latest()
            ->get();

        return Inertia::render('Admin/SectionTypes', [
            'sectionTypes' => $sectionTypes
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        SectionType::create($validated);

        return redirect()->back()->with('success', 'نوع بخش با موفقیت افزوده شد.');
    }

    public function update(Request $request, SectionType $sectionType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $sectionType->update($validated);

        return redirect()->back()->with('success', 'نوع بخش با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(SectionType $sectionType)
    {
        $sectionType->delete();
        return redirect()->back()->with('success', 'نوع بخش با موفقیت حذف شد.');
    }
}
