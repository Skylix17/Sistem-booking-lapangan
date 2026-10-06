<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Customer</h2>
            <a href="{{ route('admin.customers.edit', $customer) }}" class="text-sm text-indigo-600 hover:underline">Edit</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash />

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <dl class="grid grid-cols-3 gap-y-3 text-sm">
                    <dt class="text-gray-500">Nama</dt>
                    <dd class="col-span-2 font-medium">{{ $customer->name }}</dd>

                    <dt class="text-gray-500">Email</dt>
                    <dd class="col-span-2">{{ $customer->email }}</dd>

                    <dt class="text-gray-500">Terdaftar</dt>
                    <dd class="col-span-2">{{ $customer->created_at->format('d/m/Y H:i') }}</dd>

                    <dt class="text-gray-500">Terakhir Login</dt>
                    <dd class="col-span-2">
                        {{ $customer->last_login_at ? $customer->last_login_at->format('d/m/Y H:i') . ' (' . $customer->last_login_at->diffForHumans() . ')' : 'Belum pernah login' }}
                    </dd>

                    <dt class="text-gray-500">Status Akun</dt>
                    <dd class="col-span-2"><x-status-badge :status="$customer->status" /></dd>

                    <dt class="text-gray-500">Jumlah Booking</dt>
                    <dd class="col-span-2">{{ $bookings->count() }}</dd>
                </dl>

                <a href="{{ route('admin.customers.index') }}" class="mt-6 inline-block text-sm text-gray-600 dark:text-gray-400 hover:underline">&larr; Kembali</a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                <h3 class="text-lg font-semibold">Riwayat Booking ({{ $bookings->count() }})</h3>

                <table class="mt-3 min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-left text-xs uppercase text-gray-500">
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
                                <td class="py-2 pr-4 font-medium">{{ $booking->schedule->field->nama_lapangan }}</td>
                                <td class="py-2 pr-4">{{ $booking->schedule->tanggal->format('d/m/Y') }}</td>
                                <td class="py-2 pr-4">{{ substr($booking->schedule->jam_mulai, 0, 5) }} - {{ substr($booking->schedule->jam_selesai, 0, 5) }}</td>
                                <td class="py-2 pr-4">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                <td class="py-2 pr-4"><x-status-badge :status="$booking->status" /></td>
                                <td class="py-2">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="text-indigo-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-6 text-center text-gray-500">Belum ada booking.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
