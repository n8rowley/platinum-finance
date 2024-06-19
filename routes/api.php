<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportTransactionsController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;

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

Route::post('/upload-individual-transactions',[ImportTransactionsController::class, 'uploadTransactions'])
    ->name('upload-transactions');

Route::post('/upload-statements', [ImportTransactionsController::class, 'uploadFiles'])
    ->name('upload-statements');

Route::apiResource('bankAccounts', BankAccountController::class);

Route::apiResource('categories', CategoryController::class);

Route::apiResource('categories.subCategories', SubCategoryController::class);

Route::get('/transactions/oldest', [TransactionController::class,'oldest'])->name('oldest-transaction');

Route::apiResource('transactions', TransactionController::class)->only([
    'index', 'update', 'show',
]);

Route::post('/expenses/by-transaction/{transaction}',[ExpenseController::class,'storeByTransaction'])->name('store-expenses-by-transaction');
Route::get('/expenses/grouped-data',[ExpenseController::class, 'getGroupedExpenses'])->name('get-grouped-expenses');
