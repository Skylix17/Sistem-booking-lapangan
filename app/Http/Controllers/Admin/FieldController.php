<?php

namespace App\Http\Controllers\Admin;

use App\Models\Field;
use iluminate\validation\rule;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Browse
    public function index()
    {
        $fields = Field::latest()->paginate(10);

        return view('admin.fields.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Add
    public function create()
    {
        return view('admin.fields.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    // Simpan lapangan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis_olahraga' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'fasilitas' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => [
                'required',
                Rule::in(['available', 'unavailable']),
            ],
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('fields', 'public');
        }

        Field::create($validated);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Lapangan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    // Read
    public function show(Field $field)
    {
        return view('admin.fields.show', compact('field'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Edit
    public function edit(Field $field)
    {
        return view('admin.fields.edit', compact('field'));
    }


    /**
     * Update the specified resource in storage.
     */
    // Update
    public function update(Request $request, Field $field)
    {
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis_olahraga' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'fasilitas' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => [
                'required',
                Rule::in(['available', 'unavailable']),
            ],
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($field->foto) {
                Storage::disk('public')->delete($field->foto);
            }
            $validated['foto'] = $request->file('foto')
                ->store('fields', 'public');
        }

        $field->update($validated);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Lapangan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    // Delete
    public function destroy(Field $field)
    {
        // menghindari penghapusan lapangan jika masih memiliki jadwal
        if ($field->schedules()->exists()) {
            return back()->with(
                'error',
                'Lapangan masih memiliki jadwal. Ubah status menjadi unavailable.'
            );
        }
        // Delete photo if exists
        if ($field->foto) {
            Storage::disk('public')->delete($field->foto);
        }

        $field->delete();

        return redirect()->route('admin.fields.index')
            ->with('success', 'Lapangan berhasil dihapus.');
    }
}
