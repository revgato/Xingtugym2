<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Room;
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
        if (Auth::user()->role == 'gym-owner') {
            if (Room::where('ownerid', auth()->user()->id)->exists()) {
                return redirect()->route('gym.owner.show')->with('success', 'Welcome to create gym');
            } else {
                return redirect()->route('gym.owner.show')->with('success', 'Welcome to gym owner dashboard');
            }
        }
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
