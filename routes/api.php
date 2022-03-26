<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CashFlowController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\TransactionController;
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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::apiResource('categories',CategoryController::class);
    Route::apiResource('transaction',TransactionController::class);
    Route::apiResource('loan',LoanController::class);
    Route::apiResource('todo',TodoController::class);
    Route::get('/income',[CashFlowController::class,'income']);
    Route::get('/expense',[CashFlowController::class,'expense']);
    Route::get('/totalIncome',[CashFlowController::class,'totalIncome']);
    Route::get('/totalExpanses',[CashFlowController::class,'totalExpenses']);
});
