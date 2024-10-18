<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function() {
        return redirect('/companies');
    })->name('dashboard');

    Route::get('/companies', [\App\Http\Controllers\CompanyController::class, 'index'])->name('companies');
    Route::get('/companies/create', [\App\Http\Controllers\CompanyController::class, 'create'])->name('company.create');
    Route::post('/companies/create', [\App\Http\Controllers\CompanyController::class, 'store'])->name('company.store');

    Route::middleware(\App\Http\Middleware\CompanyOwnerMiddleware::class)->group(function () {
        Route::get('/companies/{company}/edit', [\App\Http\Controllers\CompanyController::class, 'edit'])->name('company.edit');
        Route::put('/companies/{company}', [\App\Http\Controllers\CompanyController::class, 'update'])->name('company.update');
        Route::post('/companies/{company}/delete', [\App\Http\Controllers\CompanyController::class, 'delete'])->name('company.delete');
        Route::post('/companies/{id}/restore', [\App\Http\Controllers\CompanyController::class, 'restore'])->name('company.restore');
        Route::post('/companies/{id}/force-delete', [\App\Http\Controllers\CompanyController::class, 'forceDelete'])->name('company.force-delete');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
