<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Guide;
use App\Models\Admin;

class AuthController extends Controller
{
    /**
     * Guide Login
     */
    public function guideLogin(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string',
        ]);

        $guide = Guide::where('mobile_number', $request->mobile_number)->first();

        if (! $guide) {
            throw ValidationException::withMessages([
                'mobile_number' => ['The provided mobile number is incorrect.'],
            ]);
        }

        $token = $guide->createToken('guide-token')->plainTextToken;

         // Save the token in the session
        //$request->session()->put('admin_token', $token);
        
        return response()->json([
            'user' => $guide,
            'token' => $token,
        ]);
    }

    /**
     * Admin Login
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'admin' => $admin,
        ]);
    }

}
