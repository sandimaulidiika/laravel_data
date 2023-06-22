<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth()->attempt($data)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'You success login');;
        } else {
            return back()->with('failed', 'Email or password is wrong');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'You have been logged out');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|max:50|confirmed',
            'password_confirmation' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password_confirmation)
        ];

        $user = User::create($data);

        if ($user) {
            return redirect()->route('login')->with('success', 'You have been registered, please login');
        } else {
            return redirect()->route('register')->with('failed', 'Failed to register');
        }
    }
}
