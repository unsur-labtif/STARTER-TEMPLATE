<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use App\Imports\BooksImport;

use App\Models\Book;
use App\Models\anggota;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function anggota()
    {
        $user = Auth::user();
        $anggota = anggota::all();
        return view('anggota', compact('user', 'anggota'));
    }
    public function submit_anggota(Request $req)
    {
        $validate = $req->validate([
            'nisn' => 'required|max:255',
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'kelas' => 'required',
        ]);

        $anggota = new anggota;

        $anggota->nisn = $req->get('nisn');
        $anggota->nama = $req->get('nama');
        $anggota->tgl_lahir = $req->get('tgl_lahir');
        $anggota->kelas = $req->get('kelas');

        if ($req->hasFile('foto')) {
            $extension = $req->file('foto')->extension();

            $filename = 'foto_anggota_'.time().'.'.$extension;

            $req->file('foto')->storeAs(
                'public/foto_anggota', $filename
            );

            $anggota->foto = $filename;
        }

        $anggota->save();

        $notification = array(
            'message' => 'Data Anggota Berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.anggota') -> with($notification);
    }
        // AJAX PROCCESS
    public function getDataAnggota($id)
    {
        $anggota = anggota::find($id);

        return response()->json($anggota);
    }
    public function update_anggota(Request $req)
    {
        $anggota = anggota::find($req->get('id'));

        $validate = $req->validate([
            'nisn' => 'required|max:255',
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'kelas' => 'required',
        ]);

        $anggota->nisn = $req->get('nisn');
        $anggota->nama = $req->get('nama');
        $anggota->tgl_lahir = $req->get('tgl_lahir');
        $anggota->kelas = $req->get('kelas');

        if ($req->hasFile('foto'))
            {
                $extension = $req->file('foto')->extension();
                $filename = 'foto_anggota_'.time().'.'.$extension;
                $req->file('foto')->storeAs(
                    'public/foto_anggota', $filename
                );

                Storage::delete('public/foto_anggota/'.$req->get('old_anggota'));

                $anggota->foto = $filename;
            }

                $anggota->save();

                $notification = array(
                    'message' => 'Data Anggota berhasil diubah',
                    'alert-type' => 'success'
                );

                return redirect()->route('admin.anggota')->with($notification);

    }
    public function delete_anggota($id)
    {
        $anggota = anggota::find($id);
        Storage::delete('public/foto_anggota/'.$anggota->foto);
        $anggota->delete();

        $success = true;
        $message = "Data anggota berhasil dihapus";

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }


    public function transaksi()
    {
        return view('transaksi');
    }
    public function laporan()
    {
        return view('laporan');
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
    public function submit_book(Request $req)
    {
        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
        ]);

        $book = new Book;

        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if ($req->hasFile('cover')) {
            $extension = $req->file('cover')->extension();

            $filename = 'cover_Buku_'.time().'.'.$extension;

            $req->file('cover')->storeAs(
                'public/cover_buku', $filename
            );

            $book->cover = $filename;
        }

        $book->save();

        $notification = array(
            'message' => 'Data buku Berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books') -> with($notification);
    }

    // AJAX PROCCESS
    public function getDataBuku($id)
    {
        $buku = Book::find($id);

        return response()->json($buku);
    }

    public function update_book(Request $req)
    {
        $book = Book::find($req->get('id'));

        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
        ]);

        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if ($req->hasFile('cover'))
            {
                $extension = $req->file('cover')->extension();
                $filename = 'cover_buku_'.time().'.'.$extension;
                $req->file('cover')->storeAs(
                    'public/cover_buku', $filename
                );

                Storage::delete('public/cover_buku/'.$req->get('old_cover'));

                $book->cover = $filename;
            }

                $book->save();

                $notification = array(
                    'message' => 'Data buku berhasil diubah',
                    'alert-type' => 'success'
                );

                return redirect()->route('admin.books')->with($notification);

    }

    public function delete_book($id)
    {
        $book = Book::find($id);
        Storage::delete('public/cover_buku/'.$book->cover);
        $book->delete();

        $success = true;
        $message = "Data buku berhasil dihapus";

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function print_books()
    {
        $books = Book::all();
        $pdf = PDF::loadview('print_books',['books'=> $books]);
        return $pdf->download('data_buku.pdf');
    }

    public function export()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }

    public function import(Request $req)
    {
        Excel::import(new BooksImport, $req->file('file'));
        $notification = array(
            'message' => 'Import data berhasil dilakukan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }

}

