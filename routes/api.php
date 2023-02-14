<?php

use App\Api\Controllers\FileController;
use App\Api\Controllers\ProductCategoryController;
use App\Api\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('files')->group(function () {
    Route::post('store', [FileController::class, 'store']);
});

Route:: prefix('product-categories')->group(function () {
    Route::get('/', [ProductCategoryController::class, 'index']);
    Route::post('store', [ProductCategoryController::class, 'store']);
    Route::get('{productCategory}/show', [ProductCategoryController::class, 'show']);
    Route::patch('{productCategory}/update', [ProductCategoryController::class, 'update']);
    Route::delete('{productCategory}/delete', [ProductCategoryController::class, 'destroy']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('store', [ProductController::class, 'store']);
    Route::get('{product}/show', [ProductController::class, 'show']);
    Route::patch('{product}/update', [ProductController::class, 'update']);
    Route::delete('{product}/delete', [ProductController::class, 'destroy']);
});
