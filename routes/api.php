<?php

use App\Http\Controllers\API\Product\ProductController;
use App\Http\Controllers\Api\Video\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->name('products.')->group(function(){
    Route::get('list',[ProductController::class,'list'])->name('list');
    Route::post('store',[ProductController::class,'store'])->name('store');
    Route::delete('destroy/{id}',[ProductController::class,'destroy'])->name('destroy');
    Route::post('{id}/update',[ProductController::class,'update'])->name('update');
});
Route::get('videolist',[VideoController::class,'list'])->name('videolist');
