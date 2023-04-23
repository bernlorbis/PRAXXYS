<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\VideoPlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['auth']], function () {
  Route::inertia('/', 'Dashboard')->name('dashboard');

  Route::post('/validate-product-name', [ProductController::class, 'isProductNameAvailable'])
    ->name('validate.product.name');

  Route::resource('products', ProductController::class)
    ->except('show')
    ->middleware('admin');

  Route::resource('product-images', ProductImageController::class)
    ->only(['store', 'destroy']);

  Route::get('/video-player', [VideoPlayerController::class, 'index'])
    ->name('video-player')
    ->middleware('admin');

  Route::post('logout', function (Request $request) {
    \Illuminate\Support\Facades\Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('login');
  })->name('logout');
});

Route::group(['middleware' => ['guest']], function () {
  Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

  Route::post('/login', [LoginController::class, 'login'])
    ->name('post.login');
});
