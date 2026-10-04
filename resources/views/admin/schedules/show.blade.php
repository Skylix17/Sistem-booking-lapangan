<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Jadwal</h2>
            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-sm text-indigo-600 hover:underline">Edit</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash />

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <dl class="grid grid-cols-3 gap-y-3 text-sm">
                    <dt class="text-gray-500">Lapangan</dt>
                    <dd class="col-span-2 font-medium">{{ $schedule->field->nama_lapangan }} ({{ $schedule->field->jenis_olahraga }})</dd>

                    <dt class="text-gray-500">Tanggal</dt>
                    <dd class="col-span-2">{{ $schedule->tanggal->format('d/m/Y') }}</dd>

                    <dt class="text-gray-500">Jam</dt>
                    <dd class="col-span-2">{{ substr($schedule->jam_mulai, 0, 5) }} - {{ substr($schedule->jam_selesai, 0, 5) }}</dd>

                    <dt class="text-gray-500">Status</dt>
                    <dd class="col-span-2"><x-status-badge :status="$schedule->status" /></dd>
                </dl>

                <a href="{{ route('admin.schedules.index') }}" class="mt-6 inline-block text-sm text-gray-600 dark:text-gray-400 hover:underline">&larr; Kembali</a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold">Riwayat Booking</h3>
                @forelse ($schedule->bookings as $booking)
                    <div class="mt-3 flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2 text-sm">
                        <div>
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="font-medium text-indigo-600 hover:underline">
                                #{{ $booking->id }} - {{ $booking->user->name }}
                            </a>
                            <div class="text-xs text-gray-500">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                        </div>
                        <x-status-badge :status="$booking->status" />
                    </div>
                @empty
                    <p class="mt-3 text-sm text-gray-500">Belum ada booking untuk jadwal ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
