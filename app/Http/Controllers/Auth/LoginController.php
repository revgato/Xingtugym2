<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // return view('auth.login');
        return "login";
    }

    public function login(Request $request)
    {
        // // Validate the form data
        // $this->validate($request, [
        //     'email' => 'required|email',
        //     'password' => 'required|min:8',
        // ]);
        // 
        // // Attempt to log the user in
        // if (auth()->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        //     // If successful, then redirect to their intended location
        //     return redirect()->intended(route('home'));
        // }
        // 
        // // If unsuccessful, then redirect back to the login with the form data
        // return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('home');
    }
}
