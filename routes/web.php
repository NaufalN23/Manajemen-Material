<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\MaterialReturnController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication routes
Auth::routes();


// Protected routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Materials - All users can view
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    
    Route::get('/materials/create/2', [MaterialController::class, 'create']);

    // Admin only routes
    Route::middleware(['auth'])->group(function () {

        // Material CRUD
        Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
        Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
        Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
        
        
        // Reports
        Route::resource('reports', ReportController::class);
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    });

    // Approval routes
        
        Route::post('/material-returns/{materialReturn}/accept', [MaterialReturnController::class, 'accept'])->name('material-returns.accept');
        Route::post('/material-returns/{materialReturn}/reject', [MaterialReturnController::class, 'reject'])->name('material-returns.reject');
        
    // Material Requests - All authenticated users
    Route::resource('material-requests', MaterialRequestController::class);
    Route::post('/material-requests/{materialRequest}/approve', [MaterialRequestController::class, 'approve'])->name('material-requests.approve');
    Route::post('/material-requests/{materialRequest}/reject', [MaterialRequestController::class, 'reject'])->name('material-requests.reject');
    
    // Material Returns - All authenticated users
    Route::resource('material-returns', MaterialReturnController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
