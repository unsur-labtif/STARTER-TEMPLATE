<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Sabberworm\CSS\Property\Import;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');

// Route::get('/test', function () {
//     // return $user = Auth::user();
//     return Auth::id();
// });

Auth::routes();

// Route::get('/home', function () {
//     return view('home');
// })->name('home')->middleware('auth');


Route::get('admin/home', [AdminController::class, 'index'])->name('admin.home')->middleware('is_admin');
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('admin/books', [AdminController::class, 'books'])->name('admin.books')->middleware('is_admin');

//Pengelolaan Buku update
Route::post('admin/books', [AdminController::class, 'submit_book'])->name('admin.book.submit')->middleware('is_admin');


//update
Route::patch('admin/home/update', [AdminController::class, 'update_book'])->name('admin.book.update')->middleware('is_admin');

//edit
Route::get('admin/ajaxadmin/dataBuku{id}', [AdminController::class, 'getDataBuku']);

//delete

Route::post('admin/books/delete/{id}', [AdminController::class, 'delete_book'])->name('admin.book.delete')->middleware('is_admin');

// PDF Concluion

Route::get('admin/print_books', [AdminController::class, 'print_books'])->name('admin.print.books')->middleware('is_admin');

// Excel

//Export Excel
Route::get('admin/books/export', [AdminController::class, 'export'])->name('admin.book.export')->middleware('is_admin');

// Import Excel

Route::post('admin/books/import', [AdminController::class, 'imports'])->name('admin.book.import')->middleware('is_admin');
