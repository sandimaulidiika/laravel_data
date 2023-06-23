<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // $request->user()->authorizeRoles(['user', 'admin']);
        return view('profile.index', [
            'user' => $request->user()
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }


        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $filename = time() . '.' . $image->getClientOriginalExtension();
        //     $image->storeAs('public/images', $filename);
        //     $user->image = $filename;
        // }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('password', [
            'password' => ['required', 'current_password']
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'User has ben deleted successfully');
    }
}
