<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\EcommerceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('products',[ProductController::class,'index'])->name('products');
    Route::get('create-products',[ProductController::class,'create'])->name('create-products');
    Route::get('edit-products/{id}',[ProductController::class,'edit'])->name('edit-products');
    Route::get('videos',function (){
        return inertia('Admin/Video/Index');
    })->name('videos');
   
    Route::get('praxxys-ecommerce',[EcommerceController::class,'index'])->name('praxxys-ecommerce');
    Route::get('cart',[CartController::class, 'index'])->name('cart');

    Route::post('payment',[PaymentController::class,'pay'])->name('payment');
    Route::get('success', [PaymentController::class, 'success']); 
    Route::get('failed', [PaymentController::class, 'failed']); 
});
