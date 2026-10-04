<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    // Daftar lapangan yang tersedia, dengan filter jenis olahraga
    public function index(Request $request)
    {
        $jenisList = Field::where('status', 'available')
            ->distinct()
            ->orderBy('jenis_olahraga')
            ->pluck('jenis_olahraga');

        $fields = Field::where('status', 'available')
            ->when($request->filled('jenis'), fn ($q) => $q->where('jenis_olahraga', $request->jenis))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('customer.fields.index', compact('fields', 'jenisList'));
    }

    // Detail lapangan + jadwal yang masih tersedia
    public function show(Field $field)
    {
        abort_if($field->status !== 'available', 404);

        $schedules = $field->schedules()
            ->where('status', 'available')
            ->where(function ($q) {
                $q->whereDate('tanggal', '>', now()->toDateString())
                  ->orWhere(function ($q) {
                      $q->whereDate('tanggal', now()->toDateString())
                        ->where('jam_mulai', '>', now()->format('H:i:s'));
                  });
            })
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy(fn ($s) => $s->tanggal->toDateString());

        // Jadwal yang sudah diajukan (pending) oleh user ini
        $myPending = Booking::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->pluck('schedule_id')
            ->all();

        return view('customer.fields.show', compact('field', 'schedules', 'myPending'));
    }
}
