<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            return redirect()->route('dashboard')->with('success', 'You success login');;
        } else {
            return redirect()->route('login')->with('failed', 'Email or Password is Wrong');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'You have been logged out');
    }
}
