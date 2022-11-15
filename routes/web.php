<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
