<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Http\Controllers\Controller;
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
                'message' => 'Request Failed!'

            ], 401);
        }
    }
    public function create(Request $req)
    {

        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'cover' => 'image|file|max:2048'
        ]);

        if ($req->hasFile('cover')) {
            $extension = $req->file('cover')->extension();

            $filename = 'cover_buku_' . time() . '.' . $extension;
            $req->file('cover')->storeAs('public/cover_buku', $filename);
            $validate['cover'] = $filename;
        }

        Book::create($validate);

        return response()->json([
            'message' => 'Buku Berhasil Di tambahkan +',
            'book' => $validate,
        ], 200);
    }

    public function update(Request $req, $id)
    {
        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'cover' => 'image|file|max:2048'
        ]);

        if ($req->hasFile('cover')) {
            $extension = $req->file('cover')->extension();

            $filename = 'cover_buku_' . time() . '.' . $extension;

            $req->file('cover')->storeAs('public/cover_buku', $filename);
            $validate['cover'] = $filename;
        }


        $book = Book::find($id);
        Storage::delete('public/cover_buku/' . $book->cover);
        $book->update($validate);

        return response()->json([
            'message' => 'Buku berhasil di ubah',
            'book' => $book,
        ], 200);
    }
    public function delete($id)
    {
        $book = Book::find($id);

        Storage::delete('public/cover_buku' . $book->cover);

        $book->delete();
        return response()->json([
            'message' => 'Buku berhasil di delete',
        ], 200);
    }
}
