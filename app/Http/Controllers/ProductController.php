<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\category;

class ProductController extends Controller
{    
    // List Product di bagian admin index
    public function index()
    {
        $products = Product::with('categories')->get();
        return view('admin.index', compact('products')); 
    }

    // Form tambah data produk di admin 
    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories')); 
    }
    
    // proses simpan data produk baru di admin
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image',
            'stock' => 'required|numeric', 
            'categories' => 'required|array',
        ]);

        // simpan gambar
        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $validate['name'],
            'price' => $validate['price'],
            'description' => $validate['description'],
            'image' => $imagePath,
            'stock' => $validate['stock'], 
        ]);

        // relasi kategori
        $product->categories()->attach($request->categories);

        return redirect()->route('admin.index')->with('success', 'Product berhasil ditambahkan!');
    }
    
    // Form edit data produk di admin
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.edit', compact('product', 'categories'));
    }
    
    // proses update data produk di admin    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'stock' => 'required|numeric',
            'image' => 'nullable|image',
            'categories' => 'required|array',
        ]);
        
        $product->update([
            'name' => $validate['name'],
            'price' => $validate['price'],
            'description' => $validate['description'],
            'stock' => $validate['stock'],
        ]);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');

            $product->update([
                'image' => $imagePath
            ]);
        }
        
        $product->categories()->sync($validate['categories']);

        return redirect()->route('admin.index')
            ->with('success', 'Product berhasil diupdate!');
    }
        
    // proses hapus data produk di admin    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->categories()->detach();
        $product->delete();

        return redirect()->route('admin.index')->with('success', 'Product berhasil dihapus!');
    }
    
    // bagian landing page untuk menampilkan semua produk
    public function landing()
    {
        $products = Product::with('categories')->get();
        return view('landing', compact('products'));
    }
}