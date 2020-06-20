<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
// use App\Http\Middleware\Authenticate.php;

// use Illuminate\Support\Facades\Auth;

// use Auth;

class EditorController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('editor');
    }


    public function index()
    {
        return view('admin.editor');
    }
}
