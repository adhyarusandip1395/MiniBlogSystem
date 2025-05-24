<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Container\Attributes\Auth;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('customer.register');
Route::post('/login', [AuthController::class, 'login'])->name('customer.login');

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.edit');

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [PostController::class, 'index'])->name('post.list');  
    Route::get('/post/add',[PostController::class,'add'])->name('post.add');

    Route::get('/logout', [AuthController::class, 'logout'])->name('customer.logout');


    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('post.delete');
});

Route::get('/posts/{id}/comments', [CommentController::class, 'index']);
Route::middleware('auth:sanctum')->post('/posts/{id}/comments', [CommentController::class, 'store']);