<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Cari Lapangan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <form method="GET" class="mb-5 flex items-center gap-3">
                <select name="jenis"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                    <option value="">Semua olahraga</option>
                    @foreach ($jenisList as $jenis)
                        <option value="{{ $jenis }}" @selected(request('jenis') === $jenis)>{{ $jenis }}</option>
                    @endforeach
                </select>
                <x-primary-button>Filter</x-primary-button>
            </form>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($fields as $field)
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden text-gray-900 dark:text-gray-100">
                        @if ($field->foto)
                            <img src="{{ asset('storage/' . $field->foto) }}" alt="{{ $field->nama_lapangan }}" class="h-44 w-full object-cover">
                        @else
                            <div class="h-44 w-full bg-gray-200"></div>
                        @endif
                        <div class="p-4">
                            <div class="text-xs uppercase tracking-wide text-indigo-600">{{ $field->jenis_olahraga }}</div>
                            <h3 class="mt-1 text-lg font-semibold">{{ $field->nama_lapangan }}</h3>
                            <p class="text-sm text-gray-500">{{ $field->lokasi }}</p>
                            <p class="mt-2 font-medium">Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/ jam</span></p>
                            <a href="{{ route('customer.fields.show', $field) }}"
                               class="mt-4 inline-block rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                Lihat Jadwal
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada lapangan yang tersedia.</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $fields->links() }}</div>
        </div>
    </div>
</x-app-layout>
