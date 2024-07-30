<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk login dan logout
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang dilindungi oleh middleware auth
Route::middleware('auth')->group(function () {
    // Route untuk admin
    Route::middleware('roles:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        });

        Route::prefix('kasirs')->group(function () {
            Route::get('/', [KasirController::class, 'index'])->name('kasirs.index');
            Route::get('/create', [KasirController::class, 'create'])->name('kasirs.create');
            Route::post('/', [KasirController::class, 'store'])->name('kasirs.store');
            Route::get('/{id}/edit', [KasirController::class, 'edit'])->name('kasirs.edit');
            Route::put('/{id}', [KasirController::class, 'update'])->name('kasirs.update');
            Route::delete('/{id}', [KasirController::class, 'destroy'])->name('kasirs.destroy');
        });

        Route::prefix('transactions')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
            Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
            Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');
            Route::get('/{id}', [TransactionController::class, 'show'])->name('transactions.show');
            Route::get('/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
            Route::put('/{id}', [TransactionController::class, 'update'])->name('transactions.update');
            Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
        });

        Route::prefix('report')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('report.index');
            Route::get('/filter', [ReportController::class, 'filter'])->name('report.filter');
            Route::get('/print/{start_date}/{end_date}', [ReportController::class, 'print'])->name('report.print');
        });
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::get('/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/{id}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });

    Route::prefix('report')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('report.index');
        Route::get('/filter', [ReportController::class, 'filter'])->name('report.filter');
        Route::get('/print/{start_date}/{end_date}', [ReportController::class, 'print'])->name('report.print');
    });
});
