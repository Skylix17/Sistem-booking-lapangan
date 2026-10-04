<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kelola Lapangan</h2>
            <a href="{{ route('admin.fields.create') }}"
               class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-indigo-500">
                + Tambah Lapangan
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-left text-xs uppercase text-gray-500">
                            <th class="py-2 pr-4">Foto</th>
                            <th class="py-2 pr-4">Nama</th>
                            <th class="py-2 pr-4">Jenis</th>
                            <th class="py-2 pr-4">Lokasi</th>
                            <th class="py-2 pr-4">Harga/Jam</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fields as $field)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="py-2 pr-4">
                                    @if ($field->foto)
                                        <img src="{{ asset('storage/' . $field->foto) }}" alt="" class="h-12 w-16 rounded object-cover">
                                    @else
                                        <div class="h-12 w-16 rounded bg-gray-200"></div>
                                    @endif
                                </td>
                                <td class="py-2 pr-4 font-medium">{{ $field->nama_lapangan }}</td>
                                <td class="py-2 pr-4">{{ $field->jenis_olahraga }}</td>
                                <td class="py-2 pr-4">{{ $field->lokasi }}</td>
                                <td class="py-2 pr-4">Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }}</td>
                                <td class="py-2 pr-4"><x-status-badge :status="$field->status" /></td>
                                <td class="py-2 whitespace-nowrap">
                                    <a href="{{ route('admin.fields.show', $field) }}" class="mr-3 text-gray-600 dark:text-gray-300 hover:underline">Detail</a>
                                    <a href="{{ route('admin.fields.edit', $field) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('admin.fields.destroy', $field) }}" class="inline"
                                          onsubmit="return confirm('Hapus lapangan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-3 text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-6 text-center text-gray-500">Belum ada lapangan.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $fields->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
