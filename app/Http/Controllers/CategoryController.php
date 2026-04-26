<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product; 
use App\Models\category;

class CategoryController extends Controller
{
    //menampilkan semua kategori 
    public function index()
    {
        $categories = category::with('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    //menampilkan form tambah kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    //menyimpan kategori baru
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);

        category::create($validate);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    //update kategori
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);
        $category = category::findOrFail($id);
        $category->update($validate);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    //menghapus kategori
    public function destroy(Category $category, $id)
    {
        $category = Category::findOrFail($id);
        $category->products()->detach();
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}