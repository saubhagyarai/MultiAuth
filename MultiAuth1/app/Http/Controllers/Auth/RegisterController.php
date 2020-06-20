<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use Mail;
use App\Mail\verifyEmail;
use App\User;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // Create user first
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verifyToken' => Str::random(40),
        ]);

        // Find User by user id that from just created user
        $thisUser = User::findOrFail($user->id);

        // Call sendEmail function and pass the user info
        $this->sendEmail($thisUser);

        return $user;
    }


    public function sendEmail($thisUser)
    {
        // Mail 
        Mail::to($thisUser['email'])->send(new VerifyEmail($thisUser));
    }

    public function verifyEmailFirst()
    {
        return view('auth.verify');
    }

    public function sendEmailDone($email, $verifyToken)
    {
        $user = User::where(['email' => $email, 'verifyToken' => $verifyToken])->first();

        if ($user) {
            return User::where(['email' => $email, 'verifyToken' => $verifyToken])->update(['status' => '1', 'verifyToken' => NULL]);
        } else {
            return 'user not found';
        }
    }
}
