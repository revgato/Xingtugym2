<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;

class SignUpController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showSignUpForm()
    {
        return view('auth.signup');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            // Validate role
            'role' => ['required', 'string', 'in:gym-owner,user'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'=> $data['role'],
        ]);
    }

    public function signup(Request $request)
    {
        $this->validator($request->all())->validate();

        $this->create($request->all());

        return redirect()->route('login')->with('signup_success', 'アカウントを作成しました!');
    }
}
