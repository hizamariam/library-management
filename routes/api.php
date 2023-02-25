<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/books', [BookController::class, 'index']);

    Route::middleware('isAdmin')->group(function(){
        Route::post('/store/books', [BookController::class, 'store']);
        Route::post('/update/{book}/books', [BookController::class, 'update']);
        Route::post('/destroy/{book}/books', [BookController::class, 'delete']);
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/store/users', [UserController::class, 'store']);
        Route::post('/update/{user}/users', [UserController::class, 'update']);
        Route::post('/destroy/{user}/users', [UserController::class, 'delete']);
    });
    Route::get('/my-favorites-books', [UserController::class, 'getMyFavoriteBooks']);
    Route::get('/{book}/user-store-comment', [UserController::class, 'userAddComments']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

