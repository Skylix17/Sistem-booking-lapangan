{{-- Variabel: $booking. Tombol aksi sesuai status saat ini --}}
@php
    $actions = match ($booking->status) {
        'pending'   => ['confirmed' => ['Konfirmasi', 'text-green-700'], 'rejected' => ['Tolak', 'text-red-600']],
        'confirmed' => ['completed' => ['Selesai', 'text-blue-700'], 'cancelled' => ['Batalkan', 'text-red-600']],
        default     => [],
    };
@endphp

@foreach ($actions as $status => [$label, $color])
    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="inline"
          onsubmit="return confirm('{{ $label }} booking ini?')">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="{{ $status }}">
        <button type="submit" class="mr-3 {{ $color }} hover:underline">{{ $label }}</button>
    </form>
@endforeach
