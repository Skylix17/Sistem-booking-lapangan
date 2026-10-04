<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Detail Booking #{{ $booking->id }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-flash :keys="['status']" />

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <dl class="grid grid-cols-3 gap-y-3 text-sm">
                    <dt class="text-gray-500">Customer</dt>
                    <dd class="col-span-2">{{ $booking->user->name }} ({{ $booking->user->email }})</dd>

                    <dt class="text-gray-500">Lapangan</dt>
                    <dd class="col-span-2">{{ $booking->schedule->field->nama_lapangan }} - {{ $booking->schedule->field->jenis_olahraga }}</dd>

                    <dt class="text-gray-500">Lokasi</dt>
                    <dd class="col-span-2">{{ $booking->schedule->field->lokasi }}</dd>

                    <dt class="text-gray-500">Tanggal Main</dt>
                    <dd class="col-span-2">{{ $booking->schedule->tanggal->format('d/m/Y') }}</dd>

                    <dt class="text-gray-500">Jam</dt>
                    <dd class="col-span-2">{{ substr($booking->schedule->jam_mulai, 0, 5) }} - {{ substr($booking->schedule->jam_selesai, 0, 5) }}</dd>

                    <dt class="text-gray-500">Total Harga</dt>
                    <dd class="col-span-2">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</dd>

                    <dt class="text-gray-500">Dipesan pada</dt>
                    <dd class="col-span-2">{{ $booking->tanggal_booking->format('d/m/Y') }}</dd>

                    <dt class="text-gray-500">Status</dt>
                    <dd class="col-span-2"><x-status-badge :status="$booking->status" /></dd>
                </dl>

                <div class="mt-6 flex items-center">
                    @include('admin.bookings._actions', ['booking' => $booking])
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">&larr; Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
