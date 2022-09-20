<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function edit($id, User $user){
        $edit_user = $user->findOrFail($id);
        return Inertia::render('Users/Edit', ['edit_user' => $edit_user]);
    }

    public function update(Request $request, User $user){
        // dd($request);
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
        ]);
        
        if ($user->where('id', '=', $request->id)->update($data)) {
            $request->session()->regenerate();

            return redirect()->intended('/users');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
