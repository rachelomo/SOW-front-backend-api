<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserSettingsController extends Controller
{
    public function updateSettings(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phoneNumber' => 'nullable|string|max:20',
            'companyName' => 'nullable|string|max:255',
            'streetAdress' => 'nullable|string|max:255',
            'zipCode' => 'nullable|string|max:10',
            'profileImage' => 'nullable|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->phone_number = $request->phoneNumber;
        $user->company_name = $request->companyName;
        $user->street_address = $request->streetAdress;
        $user->zip_code = $request->zipCode;

        if ($request->hasFile('profileImage')) {
            $imagePath = $request->file('profileImage')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->save();

        return response()->json(['message' => 'Settings updated successfully', 'user' => $user]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['Current password is incorrect']]], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }
}

