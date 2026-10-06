@props(['status'])

@php
    $map = [
        'pending'     => ['Menunggu', 'bg-yellow-100 text-yellow-800'],
        'confirmed'   => ['Dikonfirmasi', 'bg-green-100 text-green-800'],
        'rejected'    => ['Ditolak', 'bg-red-100 text-red-800'],
        'cancelled'   => ['Dibatalkan', 'bg-gray-200 text-gray-700'],
        'completed'   => ['Selesai', 'bg-blue-100 text-blue-800'],
        'available'   => ['Tersedia', 'bg-green-100 text-green-800'],
        'booked'      => ['Terbooking', 'bg-indigo-100 text-indigo-800'],
        'unavailable' => ['Tidak Tersedia', 'bg-gray-200 text-gray-700'],
        'active'      => ['Aktif', 'bg-green-100 text-green-800'],
        'inactive'    => ['Nonaktif', 'bg-gray-200 text-gray-700'],
    ];
    [$label, $class] = $map[$status] ?? [$status, 'bg-gray-100 text-gray-700'];
@endphp

<span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $class }}">{{ $label }}</span>
