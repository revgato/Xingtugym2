<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GymController extends Controller
{
    //
    public function create()
    {
        return view('gym.create');
    }
    public function store(Request $request)
    {
        dd($request->all());
    }
    public function edit()
    {
        return view('gym.edit');
    }
    public function update(Request $request)
    {
        dd($request->all());
    }
}
