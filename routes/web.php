<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

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

        Route::prefix('admin/pengguna')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.pengguna.index');
            Route::get('/create', [UserController::class, 'create'])->name('admin.pengguna.create');
            Route::post('/', [UserController::class, 'store'])->name('admin.pengguna.store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.pengguna.edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('admin.pengguna.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.pengguna.destroy');
        });

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
    });

    // Route untuk kasir
    Route::middleware('roles:kasir')->group(function () {
        Route::get('kasir/products', [KasirProductController::class, 'index'])->name('kasir.products.index');
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
