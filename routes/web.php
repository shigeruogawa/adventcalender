<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;


// 本の一覧、登録、詳細、更新、削除
Route::group(['prefix' => 'book'], function (): void {
    Route::get('/', [BookController::class, 'index']);
    Route::post('/create', [BookController::class, 'store']);
    Route::get('show/{id}', [BookController::class, 'show']);
    Route::put('update/{id}', [BookController::class, 'update']);
    Route::delete('delete/{id}', [BookController::class, 'destroy']);
});

// 著者一覧、登録
Route::resource('author', AuthorController::class)
    ->only(['index', 'store']);
