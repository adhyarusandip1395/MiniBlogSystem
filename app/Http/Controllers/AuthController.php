<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Brian2694\Toastr\Facades\Toastr;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        if($request->wantsJson()){
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json(['success' => true, 'token' => $token, 'user' => $user]);
        }
        
        Toastr::success('You have registered successfully. Login to continue.');
        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {

            if($request->wantsJson()){
                return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
            }

            Toastr::error('Invalid credentials.');
            return redirect()->back()->withInput();
        }

        if($request->wantsJson()){
            $token = auth()->user()->createToken('api-token')->plainTextToken;

            return response()->json(['success' => true, 'token' => $token, 'user' => auth()->user()]);
        }

        return redirect()->intended('/dashboard');
    }

    public function logout(){

        Auth::logout();
        
        Toastr::success('You have been logged out.');
        return redirect()->route('login');
    }
}
