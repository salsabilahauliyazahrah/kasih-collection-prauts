<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //menampilkan isi keranjang
    public function index(Request $request)
    {
        $cartItems = $request->session()->get('cart', []);
        return view('cart', compact('cartItems'));
    }

    //menambahkan produk ke keranjang
    public function add($productId)
    {
        $cart = session()->get('cart', []);
        $cart[] = $productId;
        session()->put('cart', $cart);


        return redirect()->back();
    }

    //menghapus produk dari keranjang 
    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, fn($id) => $id != $productId);
        session()->put('cart', array_values($cart));

        return redirect()->back();
    }

}
