<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->wishlist()->with('product')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = $request->user()->wishlist()->firstOrCreate(
            ['product_id' => $request->product_id]
        );

        return response()->json($wishlist, 201);
    }

    public function destroy($id)
    {
        Wishlist::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
