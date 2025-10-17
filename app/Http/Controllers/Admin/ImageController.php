<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::latest()->get();

        return Inertia::render('Admin/Images', [
            'images' => $images
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'path' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Image::create($validated);

        return redirect()->back()->with('success', 'تصویر با موفقیت افزوده شد.');
    }

    public function update(Request $request, Image $image)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'path' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $image->update($validated);

        return redirect()->back()->with('success', 'تصویر با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Image $image)
    {
        $image->delete();
        return redirect()->back()->with('success', 'تصویر با موفقیت حذف شد.');
    }
}
