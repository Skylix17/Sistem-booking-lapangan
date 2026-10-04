<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // Riwayat booking milik customer yang login
    public function index()
    {
        $bookings = Booking::with('schedule.field')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    // Membuat booking baru (status awal: pending)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => ['required', 'exists:schedules,id'],
        ]);

        DB::transaction(function () use ($validated) {
            $schedule = Schedule::whereKey($validated['schedule_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $field = $schedule->field;

            if ($schedule->status !== 'available' || $field->status !== 'available') {
                throw ValidationException::withMessages([
                    'schedule_id' => 'Jadwal sudah tidak tersedia.',
                ]);
            }

            $mulai = Carbon::parse($schedule->tanggal->format('Y-m-d') . ' ' . $schedule->jam_mulai);
            $selesai = Carbon::parse($schedule->tanggal->format('Y-m-d') . ' ' . $schedule->jam_selesai);

            if ($mulai->isPast()) {
                throw ValidationException::withMessages([
                    'schedule_id' => 'Jadwal ini sudah lewat.',
                ]);
            }

            $sudahAda = Booking::where('user_id', auth()->id())
                ->where('schedule_id', $schedule->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if ($sudahAda) {
                throw ValidationException::withMessages([
                    'schedule_id' => 'Anda sudah mengajukan booking untuk jadwal ini.',
                ]);
            }

            $jam = abs($mulai->diffInMinutes($selesai)) / 60;

            Booking::create([
                'user_id'         => auth()->id(),
                'schedule_id'     => $schedule->id,
                'tanggal_booking' => now()->toDateString(),
                'total_harga'     => $field->harga_per_jam * $jam,
                'status'          => 'pending',
            ]);
        });

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Booking berhasil diajukan. Menunggu konfirmasi admin.');
    }

    // Customer hanya boleh membatalkan booking yang masih pending
    public function cancel(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking berstatus menunggu yang dapat dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
