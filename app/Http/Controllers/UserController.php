<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a sign up form view.
     *
     * @return \Illuminate\Http\Response
     */
    public function signup()
    {
        return view('users.signup');
    }

    /**
     * store a signup data from user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "abcd";
    }

}
