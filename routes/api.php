<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function() 
{
    //mengambil data buku 
    Route::get('/books', [BookController::class, 'books']);

    //tambah buku
    Route::post('/book/create', [BookController::class, 'create']);

    //ubah buku
    Route::post('/book/update/{id}', [BookController::class, 'update']);
    //Delete Book
    Route::post('/book/delete/{id}', [BookController::class, 'delete']);
});

Route::post('/login', [AuthController::class, 'login']);
