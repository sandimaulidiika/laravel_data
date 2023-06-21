<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function user()
    {
        $data  = User::get();
        return view('user.index', compact('data'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|min:4'
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['email'] = $request->email;
        $data['name'] = $request->name;
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('index')->with('success', 'with the name ' . $request->fullname . ' has been added');
    }

    public function edit(Request $request, $id)
    {
        $data = User::find($id);
        return view('user.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['email'] = $request->email;
        $data['name'] = $request->name;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($data);

        return redirect()->route('index')->with('success', 'with the name ' . $request->name . ' has been updated');
    }

    public function delete(Request $request, $id)
    {
        $data = User::find($id);
        if ($data) {
            $data->delete();
        }
        return redirect()->route('index')->with('success', 'Has been deleted');
    }
}
