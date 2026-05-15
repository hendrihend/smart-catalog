<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|min:3',
            'deskripsi' => 'required',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('foto_produk')->store('produk', 'public');

        Category::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'foto_produk' => $imagePath,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => 'required|min:3',
            'deskripsi' => 'required',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto_produk')) {
            // Hapus gambar lama jika ada gambar baru
            if ($category->foto_produk && Storage::disk('public')->exists($category->foto_produk)) {
                Storage::disk('public')->delete($category->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto_produk')->store('produk', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->foto_produk) {
            Storage::disk('public')->delete($category->foto_produk);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}