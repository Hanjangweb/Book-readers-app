<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    //password Update
   
    public function updatePassword(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find user by email or phone number
        $user = User::where('email', $request->identifier)
                    ->orWhere('phone_number', $request->identifier)
                    ->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'No user found with this email or phone number.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('acount.login')->with('success', 'Password successfully updated. Please log in with your new password.');
    }
}
