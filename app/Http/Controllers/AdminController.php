<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Fascades\Auth;
use Illuminate\Support\Fascades\Storage;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $user = Auth::user();
        return view('home', compact('user'));
    }
}
