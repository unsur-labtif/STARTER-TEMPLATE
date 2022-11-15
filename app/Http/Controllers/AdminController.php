<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Book;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();


        return view('home', compact('user'));
    }

    public function books()
    {
        $user = Auth::user();
        $books = Book::all();
        return view('book', compact('user', 'books'));
    }
}
