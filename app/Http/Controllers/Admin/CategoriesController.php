<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = EventCategory::all();
        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:event_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama wajib diisi',
            'icon.image' => 'File harus berupa gambar',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('categories', 'public');
        }

        EventCategory::create($validated);

        return to_route('admin.Kategori.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $category = EventCategory::findOrFail($id);
        return view('admin.kategori.edit', compact('category')); // 🔥 konsisten
    }

    public function update(Request $request, string $id)
    {
        $category = EventCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:event_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama wajib diisi',
            'icon.image' => 'File harus berupa gambar',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        if ($request->hasFile('icon')) {

            if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                Storage::disk('public')->delete($category->icon);
            }

            $validated['icon'] = $request->file('icon')->store('categories', 'public');
        } else {
            $validated['icon'] = $category->icon;
        }

        $category->update($validated);

        return to_route('admin.Kategori.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $category = EventCategory::findOrFail($id);

        // hapus gambar (kalau ada)
        if ($category->icon && Storage::disk('public')->exists($category->icon)) {
            Storage::disk('public')->delete($category->icon);
        }

        // hapus data (SELALU jalan)
        $category->delete();

        return to_route('admin.Kategori.index')
            ->with('success', 'Data berhasil dihapus');
    }
}