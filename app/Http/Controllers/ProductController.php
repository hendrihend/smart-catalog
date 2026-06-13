<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// DUA BARIS INI WAJIB ADA UNTUK FITUR EXCEL
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric|min:1000',
            'deskripsi_produk' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('foto')->store('produk', 'public');

        Products::create([
            'nama_produk' => $request->nama_produk,
            'category_id' => $request->category_id,
            'harga' => $request->harga,
            'deskripsi_produk' => $request->deskripsi_produk,
            'foto_produk' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Products $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Products $product)
    {
        $request->validate([
            'nama_produk' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric|min:1000',
            'deskripsi_produk' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'category_id' => $request->category_id,
            'harga' => $request->harga,
            'deskripsi_produk' => $request->deskripsi_produk,
        ];

        if ($request->hasFile('foto')) {
            if ($product->foto_produk && Storage::disk('public')->exists($product->foto_produk)) {
                Storage::disk('public')->delete($product->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto')->store('produk', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Products $product)
    {
        if ($product->foto_produk && Storage::disk('public')->exists($product->foto_produk)) {
            Storage::disk('public')->delete($product->foto_produk);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * FUNGSI INI YANG SEBELUMNYA HILANG/TIDAK TERBACA
     * Letakkan ini sebelum tanda kurung kurawal penutup terakhir "}"
     */
    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'laporan-katalog-umkm.xlsx');
    }
}