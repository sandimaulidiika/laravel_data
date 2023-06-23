<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $request->session()->regenerate();

        if (Auth::attempt($data)) {
            return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'You success login');
        } else {
            return back()->with('failed', 'Failed to login');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|min:3|max:50',
            'password' => 'required|min:4|max:50|confirmed',
            'password_confirmation' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password_confirmation),
            'image' => '1687409920.JPG'
        ];

        event(new Registered($data));

        $user = User::create($data);

        if ($user) {
            return redirect()->intended('login')->with('success', 'You have been registered, please login');
        } else {
            return back()->with('failed', 'Failed to register');
        }
    }
}
