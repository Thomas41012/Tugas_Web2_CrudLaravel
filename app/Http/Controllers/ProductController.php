<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        // Pastikan folder di resources/views bernama 'products'
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products',
            'price' => 'required',
            'stock' => 'required',
        ]);

        Product::create([
            'name' => $request->name,
            'code' => $request->code,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Menampilkan detail produk tertentu.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Memperbarui produk di database.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}