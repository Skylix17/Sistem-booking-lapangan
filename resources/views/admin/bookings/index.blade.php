<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kelola Booking</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash :keys="['status']" />

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-left text-xs uppercase text-gray-500">
                            <th class="py-2 pr-4">#</th>
                            <th class="py-2 pr-4">Customer</th>
                            <th class="py-2 pr-4">Lapangan</th>
                            <th class="py-2 pr-4">Tanggal Main</th>
                            <th class="py-2 pr-4">Jam</th>
                            <th class="py-2 pr-4">Total</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="py-2 pr-4">{{ $booking->id }}</td>
                                <td class="py-2 pr-4">{{ $booking->user->name }}</td>
                                <td class="py-2 pr-4 font-medium">{{ $booking->schedule->field->nama_lapangan }}</td>
                                <td class="py-2 pr-4">{{ $booking->schedule->tanggal->format('d/m/Y') }}</td>
                                <td class="py-2 pr-4">{{ substr($booking->schedule->jam_mulai, 0, 5) }} - {{ substr($booking->schedule->jam_selesai, 0, 5) }}</td>
                                <td class="py-2 pr-4">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                <td class="py-2 pr-4"><x-status-badge :status="$booking->status" /></td>
                                <td class="py-2 whitespace-nowrap">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="mr-3 text-indigo-600 hover:underline">Detail</a>
                                    @include('admin.bookings._actions', ['booking' => $booking])
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="py-6 text-center text-gray-500">Belum ada booking.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $bookings->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
