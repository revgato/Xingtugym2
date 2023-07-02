<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // return view('auth.register');
        return "register"
    }

    public function register(Request $request)
    {
        // // Validate form data
        // $this->validate($request, [
        //     'name' => 'required|max:255',
        //     'email' => 'required|unique:users|max:255',
        //     'password' => 'required|confirmed|min:8',
        // ]);

        // // Create and save the user
        // $user = new \App\Models\User;
        // $user->name = $request->name;
        // $user->email = $request->email;
        // // Hash password
        // $user->password = bcrypt($request->password);
        // $user->save();

        // // Sign the user in
        // auth()->login($user);

        // // Redirect to homepage
        // return redirect('/');
    }
}
