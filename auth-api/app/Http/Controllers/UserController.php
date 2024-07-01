<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image) {
                Storage::delete('public/' . $user->image);
            }

            // Store new image
            $path = $request->file('image')->store('profile_pictures', 'public');
            $user->image = $path;
        }

        $user->name = $request->input('name');
        $user->save();

        return response()->json($user);
    }

    public function getUserProfile()
    {
        $user = Auth::user();
        return response()->json($user);
    }
}
