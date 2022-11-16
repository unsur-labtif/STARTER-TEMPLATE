<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function books()
    {
        try {
            $books = Book::all();

            return response()->json([
                'message' => 'success',
                'books' => $books,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Request Fail !!'

            ], 401);
        }
    }

    public function create(Request $request)
    {

        $validate = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'cover' => 'image|file|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            $extension = $request->file('cover')->extension();

            $filename = 'cover_buku_' . time() . '.' . $extension();
            $request->file('cover')->storeAs('public/cover_buku', $filename);
            $validate['cover'] = $filename;
        }

        Book::create($validate);

        return response()->json([
            'message' => 'Book was Be added',
            'book' => $validate
        ], 200);
    }
}
