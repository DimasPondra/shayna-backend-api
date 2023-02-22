<?php

use App\Api\Controllers\Admin\AdminAuthController;
use App\Api\Controllers\Admin\AdminBankAccountController;
use App\Api\Controllers\Admin\AdminBankController;
use App\Api\Controllers\Admin\AdminFileController;
use App\Api\Controllers\Admin\AdminProductCategoryController;
use App\Api\Controllers\Admin\AdminProductController;
use App\Api\Controllers\Admin\AdminUserController;
use App\Api\Controllers\Client\ClientAuthController;
use App\Api\Controllers\Client\ClientCartController;
use App\Api\Controllers\Client\ClientProductController;
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

Route::prefix('client')->group(function () {
    Route::post('login', [ClientAuthController::class, 'login']);
    Route::post('register', [ClientAuthController::class, 'register']);

    Route::prefix('products')->group(function () {
        Route::get('/', [ClientProductController::class, 'index']);
        Route::get('{product:slug}', [ClientProductController::class, 'show']);
    });

    Route::middleware('auth:sanctum', 'abilities:client')->group(function () {
        Route::prefix('carts')->group(function () {
            Route::get('/', [ClientCartController::class, 'index']);
            Route::post('store', [ClientCartController::class, 'store']);
        });

        Route::post('logout', [ClientAuthController::class, 'logout']);
    });
});

Route::prefix('admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:sanctum', 'abilities:admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);

        Route::prefix('files')->group(function () {
            Route::post('store', [AdminFileController::class, 'store']);
        });

        Route:: prefix('product-categories')->group(function () {
            Route::get('/', [AdminProductCategoryController::class, 'index']);
            Route::post('store', [AdminProductCategoryController::class, 'store']);
            Route::get('{productCategory}/show', [AdminProductCategoryController::class, 'show']);
            Route::patch('{productCategory}/update', [AdminProductCategoryController::class, 'update']);
            Route::delete('{productCategory}/delete', [AdminProductCategoryController::class, 'destroy']);
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [AdminProductController::class, 'index']);
            Route::post('store', [AdminProductController::class, 'store']);
            Route::get('{product}/show', [AdminProductController::class, 'show']);
            Route::patch('{product}/update', [AdminProductController::class, 'update']);
            Route::delete('{product}/delete', [AdminProductController::class, 'destroy']);
        });

        Route::prefix('users')->group(function () {
            Route::get('/', [AdminUserController::class, 'index']);
        });

        Route::prefix('banks')->group(function () {
            Route::get('/', [AdminBankController::class, 'index']);
            Route::post('store', [AdminBankController::class, 'store']);
            Route::get('{bank}/show', [AdminBankController::class, 'show']);
            Route::patch('{bank}/update', [AdminBankController::class, 'update']);
            Route::delete('{bank}/delete', [AdminBankController::class, 'destroy']);
        });

        Route::prefix('bank_accounts')->group(function () {
            Route::get('/', [AdminBankAccountController::class, 'index']);
            Route::post('store', [AdminBankAccountController::class, 'store']);
            Route::get('{bankAccount}/show', [AdminBankAccountController::class, 'show']);
            Route::patch('{bankAccount}/update', [AdminBankAccountController::class, 'update']);
            Route::delete('{bankAccount}/delete', [AdminBankAccountController::class, 'destroy']);
        });
    });
});

