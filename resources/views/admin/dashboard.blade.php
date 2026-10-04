<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['Lapangan', $totalFields, 'text-gray-900 dark:text-gray-100'],
                    ['Booking Menunggu', $pendingBookings, 'text-yellow-600'],
                    ['Booking Dikonfirmasi', $confirmedBookings, 'text-green-600'],
                    ['Pendapatan', 'Rp ' . number_format($revenue, 0, ',', '.'), 'text-indigo-600'],
                ] as [$label, $value, $color])
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-5">
                        <div class="text-sm text-gray-500">{{ $label }}</div>
                        <div class="mt-1 text-2xl font-bold {{ $color }}">{{ $value }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.fields.index') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Kelola Lapangan</a>
                <a href="{{ route('admin.schedules.index') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Kelola Jadwal</a>
                <a href="{{ route('admin.bookings.index') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Kelola Booking</a>
            </div>
        </div>
    </div>
</x-app-layout>
