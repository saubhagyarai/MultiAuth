<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * middleware apply if you don't want unauthorized access 
     */

    // public function __construct()
    // {
    //     $this->middleware('guest:admin');
    // }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */

    public function showLinkRequestForm()
    {
        return view('admin.passwords.email');
    }

    // protected function guard()
    // {
    //     return Auth::guard('admin');
    // }

    protected function broker()
    {
        return Password::broker('admins'); //set password broker name according to guard which you have set in config/auth.php
    }
}
