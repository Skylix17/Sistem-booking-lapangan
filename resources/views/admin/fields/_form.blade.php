{{-- Variabel: $action, $method (opsional), $field (null saat tambah) --}}
@php
    $inputClass = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @isset($method) @method($method) @endisset

    <div>
        <x-input-label for="nama_lapangan" value="Nama Lapangan" />
        <x-text-input id="nama_lapangan" name="nama_lapangan" type="text" class="mt-1 block w-full"
                      :value="old('nama_lapangan', $field?->nama_lapangan)" required />
        <x-input-error :messages="$errors->get('nama_lapangan')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <div>
            <x-input-label for="jenis_olahraga" value="Jenis Olahraga" />
            <x-text-input id="jenis_olahraga" name="jenis_olahraga" type="text" class="mt-1 block w-full"
                          :value="old('jenis_olahraga', $field?->jenis_olahraga)" placeholder="Futsal, Badminton, Basket" required />
            <x-input-error :messages="$errors->get('jenis_olahraga')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="harga_per_jam" value="Harga per Jam (Rp)" />
            <x-text-input id="harga_per_jam" name="harga_per_jam" type="number" min="0" step="1000" class="mt-1 block w-full"
                          :value="old('harga_per_jam', $field ? (int) $field->harga_per_jam : '')" required />
            <x-input-error :messages="$errors->get('harga_per_jam')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="lokasi" value="Lokasi" />
        <x-text-input id="lokasi" name="lokasi" type="text" class="mt-1 block w-full"
                      :value="old('lokasi', $field?->lokasi)" required />
        <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="fasilitas" value="Fasilitas" />
        <textarea id="fasilitas" name="fasilitas" rows="2" class="{{ $inputClass }}">{{ old('fasilitas', $field?->fasilitas) }}</textarea>
        <x-input-error :messages="$errors->get('fasilitas')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="deskripsi" value="Deskripsi" />
        <textarea id="deskripsi" name="deskripsi" rows="3" class="{{ $inputClass }}">{{ old('deskripsi', $field?->deskripsi) }}</textarea>
        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <div>
            <x-input-label for="foto" value="Foto (jpg/png/webp, maks 2 MB)" />
            @if ($field?->foto)
                <img src="{{ asset('storage/' . $field->foto) }}" alt="" class="mt-1 mb-2 h-24 rounded object-cover">
            @endif
            <input id="foto" name="foto" type="file" accept="image/*"
                   class="block w-full text-sm text-gray-700 dark:text-gray-300">
            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="{{ $inputClass }}">
                <option value="available" @selected(old('status', $field?->status ?? 'available') === 'available')>Tersedia</option>
                <option value="unavailable" @selected(old('status', $field?->status) === 'unavailable')>Tidak Tersedia</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('admin.fields.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
    </div>
</form>
