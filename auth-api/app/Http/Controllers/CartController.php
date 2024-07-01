<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->cart()->with('product')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->user()->cart()->updateOrCreate(
            ['product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json($cart, 201);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update($request->all());

        return response()->json($cart);
    }

    public function destroy($id)
    {
        Cart::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
