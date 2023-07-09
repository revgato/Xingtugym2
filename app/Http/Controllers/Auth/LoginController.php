<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->route('login')->with('error', 'メールアドレスまたはパスワードが間違っています!');
    }

    protected function authenticated()
    {
        // if(Auth::user()->role == 1){
        //     return redirect()->route('admin.dashboard')->with('success', 'Welcome to admin dashboard');
        // }
        // else{
        return redirect('/')->with('success', 'Welcome to home');
        // }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
