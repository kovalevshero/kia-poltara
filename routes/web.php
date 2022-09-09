<?php

use App\Http\Controllers\{CategoryController, ContentController, ImageController, SiteController, SubscriberController};
use Illuminate\Support\Facades\{Auth, Route};

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Content Routes
    Route::get('content', [ContentController::class, 'index']);
    Route::get('content/create', [ContentController::class, 'create']);
    Route::post('content/store', [ContentController::class, 'store']);
    Route::get('content/edit/{id}', [ContentController::class, 'edit']);
    Route::post('content/update', [ContentController::class, 'update']);
    Route::get('content/search', [ContentController::class, 'search']);
    Route::get('content/get-category', [ContentController::class, 'getCategory']);
    Route::post('upload', [ImageController::class, 'uploadImage'])->name('ckeditor.upload');

    // Category Routes
    Route::get('category', [CategoryController::class, 'index']);

    // Subscriber Routes
    Route::get('subscriber', [SubscriberController::class, 'index']);
    Route::get('subscriber/delete/{id}', [SubscriberController::class, 'delete']);

    // Category Routes
    Route::get('site', [SiteController::class, 'index']);
    Route::post('site/store', [SiteController::class, 'store']);
});
