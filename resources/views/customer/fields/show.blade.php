<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $field->nama_lapangan }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash :keys="['schedule_id']" />

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden text-gray-900 dark:text-gray-100 md:flex">
                @if ($field->foto)
                    <img src="{{ asset('storage/' . $field->foto) }}" alt="{{ $field->nama_lapangan }}" class="h-56 w-full object-cover md:w-72">
                @endif
                <div class="p-5 text-sm space-y-1">
                    <div class="text-xs uppercase tracking-wide text-indigo-600">{{ $field->jenis_olahraga }}</div>
                    <div><span class="text-gray-500">Lokasi:</span> {{ $field->lokasi }}</div>
                    <div><span class="text-gray-500">Harga:</span> Rp {{ number_format($field->harga_per_jam, 0, ',', '.') }} / jam</div>
                    @if ($field->fasilitas)
                        <div><span class="text-gray-500">Fasilitas:</span> {{ $field->fasilitas }}</div>
                    @endif
                    @if ($field->deskripsi)
                        <p class="pt-2">{{ $field->deskripsi }}</p>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold">Jadwal Tersedia</h3>

                @forelse ($schedules as $tanggal => $items)
                    <div class="mt-4">
                        <div class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}
                        </div>
                        <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($items as $schedule)
                                @php
                                    $jam = abs(\Carbon\Carbon::parse($schedule->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($schedule->jam_selesai))) / 60;
                                @endphp
                                <div class="flex items-center justify-between rounded-md border border-gray-200 dark:border-gray-700 p-3">
                                    <div>
                                        <div class="font-medium">{{ substr($schedule->jam_mulai, 0, 5) }} - {{ substr($schedule->jam_selesai, 0, 5) }}</div>
                                        <div class="text-xs text-gray-500">Rp {{ number_format($field->harga_per_jam * $jam, 0, ',', '.') }}</div>
                                    </div>
                                    @if (in_array($schedule->id, $myPending))
                                        <x-status-badge status="pending" />
                                    @else
                                        <form method="POST" action="{{ route('customer.bookings.store') }}"
                                              onsubmit="return confirm('Ajukan booking untuk jadwal ini?')">
                                            @csrf
                                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                            <button type="submit"
                                                    class="rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-500">
                                                Booking
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="mt-3 text-gray-500">Belum ada jadwal tersedia untuk lapangan ini.</p>
                @endforelse
            </div>

            <a href="{{ route('customer.fields.index') }}" class="inline-block text-sm text-gray-600 dark:text-gray-400 hover:underline">&larr; Kembali</a>
        </div>
    </div>
</x-app-layout>
