<?php

use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    })->name('dashboard');

    // Dashboard Admin dan route untuk mengelola lapangan, jadwal, dan booking
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            
            //dashboard admin
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            // Route untuk mengelola lapangan
            Route::resource('fields', FieldController::class);

            // Route untuk mengelola jadwal
            Route::resource('schedules', ScheduleController::class);

            // Route untuk mengelola booking
            Route::get('/bookings', [BookingController::class, 'index'])
                ->name('bookings.index');

            Route::get('/bookings/{booking}', [BookingController::class, 'show'])
                ->name('bookings.show');

            Route::patch('/bookings/{booking}', [BookingController::class, 'update'])
                ->name('bookings.update');

        });

    // Dashboard Customer
    Route::middleware('role:customer')
        ->prefix('customer')
        ->name('customer.')
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('customer.dashboard');
            })->name('dashboard');
        });


    //profile Breeze
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';
