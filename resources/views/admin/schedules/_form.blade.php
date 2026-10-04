{{-- Variabel: $action, $method (opsional), $schedule (null saat tambah), $fields --}}
@php
    $inputClass = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-5">
    @csrf
    @isset($method) @method($method) @endisset

    <div>
        <x-input-label for="field_id" value="Lapangan" />
        <select id="field_id" name="field_id" class="{{ $inputClass }}" required>
            <option value="">-- Pilih lapangan --</option>
            @foreach ($fields as $f)
                <option value="{{ $f->id }}" @selected((int) old('field_id', $schedule?->field_id) === $f->id)>
                    {{ $f->nama_lapangan }} ({{ $f->jenis_olahraga }})
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('field_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="tanggal" value="Tanggal" />
        <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                      :value="old('tanggal', $schedule?->tanggal?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <div>
            <x-input-label for="jam_mulai" value="Jam Mulai" />
            <x-text-input id="jam_mulai" name="jam_mulai" type="time" class="mt-1 block w-full"
                          :value="old('jam_mulai', $schedule ? substr($schedule->jam_mulai, 0, 5) : '')" required />
            <x-input-error :messages="$errors->get('jam_mulai')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="jam_selesai" value="Jam Selesai" />
            <x-text-input id="jam_selesai" name="jam_selesai" type="time" class="mt-1 block w-full"
                          :value="old('jam_selesai', $schedule ? substr($schedule->jam_selesai, 0, 5) : '')" required />
            <x-input-error :messages="$errors->get('jam_selesai')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="{{ $inputClass }}">
            <option value="available" @selected(old('status', $schedule?->status ?? 'available') === 'available')>Tersedia</option>
            <option value="unavailable" @selected(old('status', $schedule?->status) === 'unavailable')>Tidak Tersedia</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div class="flex items-center gap-3 pt-2">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('admin.schedules.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
    </div>
</form>
