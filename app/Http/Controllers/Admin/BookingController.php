<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Browse: daftar semua booking
    public function index()
    {
        $bookings = Booking::with(['user', 'schedule.field'])
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    // Read: detail booking
    public function show(Booking $booking)
    {
        $booking->load(['user', 'schedule.field']);

        return view('admin.bookings.show', compact('booking'));
    }

    // Update: mengubah status booking
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'confirmed',
                    'rejected',
                    'cancelled',
                    'completed',
                ]),
            ],
        ]);

        DB::transaction(function () use ($booking, $validated) {
            $booking = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            $schedule = $booking->schedule()
                ->lockForUpdate()
                ->firstOrFail();

            $oldStatus = $booking->status;
            $newStatus = $validated['status'];

            // Booking pending
            if ($oldStatus === 'pending') {

                if ($newStatus === 'confirmed') {

                    if ($schedule->status !== 'available') {
                        throw ValidationException::withMessages([
                            'status' => 'Jadwal sudah tidak tersedia.',
                        ]);
                    }

                    // Pastikan belum ada booking aktif lain
                    $hasConfirmed = Booking::where(
                        'schedule_id',
                        $schedule->id
                    )
                        ->where('id', '!=', $booking->id)
                        ->where('status', 'confirmed')
                        ->exists();

                    if ($hasConfirmed) {
                        throw ValidationException::withMessages([
                            'status' => 'Jadwal sudah memiliki booking.',
                        ]);
                    }

                    $schedule->update([
                        'status' => 'booked',
                    ]);

                } elseif (!in_array($newStatus, [
                    'rejected',
                    'cancelled',
                ])) {
                    throw ValidationException::withMessages([
                        'status' => 'Perubahan status tidak valid.',
                    ]);
                }
            }

            // Booking confirmed
            elseif ($oldStatus === 'confirmed') {

                if (!in_array($newStatus, [
                    'cancelled',
                    'completed',
                ])) {
                    throw ValidationException::withMessages([
                        'status' => 'Perubahan status tidak valid.',
                    ]);
                }

                if ($newStatus === 'completed') {
                    // Booking selesai, jadwal tetap menjadi booked
                    // sebagai riwayat pemakaian.
                    if (
                        now()->lt(
                            \Carbon\Carbon::parse(
                                $schedule->tanggal . ' ' .
                                $schedule->jam_selesai
                            )
                        )
                    ) {
                        throw ValidationException::withMessages([
                            'status' => 'Booking belum selesai dilaksanakan.',
                        ]);
                    }
                }

                if ($newStatus === 'cancelled') {
                    // Jadwal dapat digunakan kembali jika tidak
                    // ada booking confirmed lainnya.
                    $hasOtherConfirmed = Booking::where(
                        'schedule_id',
                        $schedule->id
                    )
                        ->where('id', '!=', $booking->id)
                        ->where('status', 'confirmed')
                        ->exists();

                    if (!$hasOtherConfirmed) {
                        $schedule->update([
                            'status' => 'available',
                        ]);
                    }
                }
            }

            // Status final tidak dapat diubah kembali
            else {
                throw ValidationException::withMessages([
                    'status' => 'Booking sudah berstatus final.',
                ]);
            }

            $booking->update([
                'status' => $newStatus,
            ]);
        });

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Status booking berhasil diperbarui.');
    }
}
