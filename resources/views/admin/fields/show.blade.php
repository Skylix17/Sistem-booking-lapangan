<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Lapangan</h2>
            <a href="{{ route('admin.fields.edit', $field) }}" class="text-sm text-indigo-600 hover:underline">Edit</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-flash />
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden text-gray-900 dark:text-gray-100">
                @if ($field->foto)
                    <img src="{{ asset('storage/' . $field->foto) }}" alt="{{ $field->nama_lapangan }}" class="h-56 w-full object-cover">
                @endif
                <div class="p-6">
                    <dl class="grid grid-cols-3 gap-y-3 text-sm">
                        <dt class="text-gray-500">Nama</dt>
                        <dd class="col-span-2 font-medium">{{ $field->nama_lapangan }}</dd>

                        <dt class="text-gray-500">Jenis Olahraga</dt>
                        <dd class="col-span-2">{{ $field->jenis_olahraga }}</dd>

                        <dt class="text-gray-500">Lokasi</dt>
                        <dd class="col-span-2">{{ $field->lokasi }}</dd>

                        <dt class="text-gray-500">Harga per Jam</dt>
                        <dd class="col-span-2">Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }}</dd>

                        <dt class="text-gray-500">Fasilitas</dt>
                        <dd class="col-span-2">{{ $field->fasilitas ?: '-' }}</dd>

                        <dt class="text-gray-500">Deskripsi</dt>
                        <dd class="col-span-2">{{ $field->deskripsi ?: '-' }}</dd>

                        <dt class="text-gray-500">Jumlah Jadwal</dt>
                        <dd class="col-span-2">{{ $field->schedules()->count() }}</dd>

                        <dt class="text-gray-500">Status</dt>
                        <dd class="col-span-2"><x-status-badge :status="$field->status" /></dd>
                    </dl>

                    <a href="{{ route('admin.fields.index') }}" class="mt-6 inline-block text-sm text-gray-600 dark:text-gray-400 hover:underline">&larr; Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
