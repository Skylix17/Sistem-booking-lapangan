<?php

namespace App\Http\Controllers\Admin;

use App\Models\Field;
use App\Models\Schedule;
use Illuminate\validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Browse
    public function index()
    {
        $schedules = Schedule::with('field')
            ->orderByDesc('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Add
    public function create()
    {
        $fields = Field::where('status', 'available')->get();

        return view('admin.schedules.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Simpan jadwal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'field_id' => [
                'required',
                Rule::exists('fields', 'id')
                    ->where('status', 'available'),
            ],
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => [
                'required',
                Rule::in(['available', 'unavailable']),
            ],
        ]);

        // Mencegah jadwal yang waktunya tumpang tindih
        $bentrok = Schedule::where('field_id', $validated['field_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where('jam_mulai', '<', $validated['jam_selesai'])
            ->where('jam_selesai', '>', $validated['jam_mulai'])
            ->exists();

        if ($bentrok) {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Jadwal bertabrakan dengan jadwal lain.',
            ]);
        }

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    // Read
    public function show(Schedule $schedule)
    {
        $schedule->load('field', 'bookings');

        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Edit
    public function edit(Schedule $schedule)
    {
        $fields = Field::where('status', 'available')
            ->orWhere('id', $schedule->field_id)
            ->get();

        return view('admin.schedules.edit', compact(
            'schedule',
            'fields'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'field_id' => [
                'required',
                Rule::exists('fields', 'id')
                    ->where('status', 'available'),
            ],
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => [
                'required',
                Rule::in(['available', 'unavailable']),
            ],
        ]);

        // Jadwal dengan riwayat booking tidak boleh diedit
        if ($schedule->bookings()->exists()) {
            return back()->with(
                'error',
                'Jadwal sudah memiliki booking dan tidak dapat diubah.'
            );
        }

        $bentrok = Schedule::where('field_id', $validated['field_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where('jam_mulai', '<', $validated['jam_selesai'])
            ->where('jam_selesai', '>', $validated['jam_mulai'])
            ->where('id', '!=', $schedule->id)
            ->exists();

        if ($bentrok) {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Jadwal bertabrakan dengan jadwal lain.',
            ]);
        }

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Delete
    public function destroy(Schedule $schedule)
    {
        if ($schedule->bookings()->exists()) {
            return back()->with(
                'error',
                'Jadwal memiliki riwayat booking dan tidak dapat dihapus.'
            );
        }

        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
