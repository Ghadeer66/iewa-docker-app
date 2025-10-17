<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->get();

        return Inertia::render('Admin/Packages', [
            'packages' => $packages
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        Package::create($validated);

        return redirect()->back()->with('success', 'بسته با موفقیت افزوده شد.');
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $package->update($validated);

        return redirect()->back()->with('success', 'بسته با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->back()->with('success', 'بسته با موفقیت حذف شد.');
    }
}
