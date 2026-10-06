<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\FieldController as CustomerFieldController;
use App\Http\Controllers\ProfileController;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified', 'active'])->group(function () {

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

            // dashboard admin
            Route::get('/dashboard', function () {
                return view('admin.dashboard', [
                    'totalFields'       => Field::count(),
                    'pendingBookings'   => Booking::where('status', 'pending')->count(),
                    'confirmedBookings' => Booking::where('status', 'confirmed')->count(),
                    'revenue'           => Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_harga'),
                ]);
            })->name('dashboard');

            // Route untuk mengelola lapangan
            Route::resource('fields', FieldController::class);

            // Route untuk mengelola jadwal
            Route::resource('schedules', ScheduleController::class);

            // Route untuk mengelola data customer (BREAD)
            Route::resource('customers', CustomerController::class);

            // Route untuk mengelola booking
            Route::get('/bookings', [BookingController::class, 'index'])
                ->name('bookings.index');

            Route::get('/bookings/{booking}', [BookingController::class, 'show'])
                ->name('bookings.show');

            Route::patch('/bookings/{booking}', [BookingController::class, 'update'])
                ->name('bookings.update');
        });

    // Dashboard dan fitur Customer
    Route::middleware('role:customer')
        ->prefix('customer')
        ->name('customer.')
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('customer.dashboard');
            })->name('dashboard');

            Route::get('/fields', [CustomerFieldController::class, 'index'])->name('fields.index');
            Route::get('/fields/{field}', [CustomerFieldController::class, 'show'])->name('fields.show');

            Route::get('/bookings', [CustomerBookingController::class, 'index'])->name('bookings.index');
            Route::post('/bookings', [CustomerBookingController::class, 'store'])->name('bookings.store');
            Route::patch('/bookings/{booking}/cancel', [CustomerBookingController::class, 'cancel'])->name('bookings.cancel');
        });

    // profile Breeze
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
