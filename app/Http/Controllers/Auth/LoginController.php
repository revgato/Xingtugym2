<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        return redirect()->route('login')->with('login_error', 'メールアドレスまたはパスワードが間違っています!');
    }

    protected function authenticated()
    {
        // Update last_login_at at table users
        DB::table('users')->where('id', Auth::user()->id)->update(['last_login_at' => Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->toDateTimeString()]);

        // if(Auth::user()->role == 1){
        //     return redirect()->route('admin.dashboard')->with('success', 'Welcome to admin dashboard');
        // }
        // else{
        return redirect('/')->with('login_success', 'ログイン成功しました!');
        // }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('logout_success', 'ログアウトしました!');
    }
}
