<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SectionElement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionElementController extends Controller
{
    public function index()
    {
        $sectionElements = SectionElement::with('sectionType')
            ->latest()
            ->get();

        return Inertia::render('Admin/SectionElements', [
            'sectionElements' => $sectionElements
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_type_id' => 'required|exists:section_types,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image_path' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        SectionElement::create($validated);

        return redirect()->back()->with('success', 'عنصر بخش با موفقیت افزوده شد.');
    }

    public function update(Request $request, SectionElement $sectionElement)
    {
        $validated = $request->validate([
            'section_type_id' => 'required|exists:section_types,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image_path' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $sectionElement->update($validated);

        return redirect()->back()->with('success', 'عنصر بخش با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(SectionElement $sectionElement)
    {
        $sectionElement->delete();
        return redirect()->back()->with('success', 'عنصر بخش با موفقیت حذف شد.');
    }
}
