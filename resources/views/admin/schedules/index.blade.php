<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kelola Jadwal</h2>
            <a href="{{ route('admin.schedules.create') }}"
               class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-indigo-500">
                + Tambah Jadwal
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
                            <th class="py-2 pr-4">Lapangan</th>
                            <th class="py-2 pr-4">Tanggal</th>
                            <th class="py-2 pr-4">Jam</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedules as $schedule)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="py-2 pr-4 font-medium">{{ $schedule->field->nama_lapangan }}</td>
                                <td class="py-2 pr-4">{{ $schedule->tanggal->format('d/m/Y') }}</td>
                                <td class="py-2 pr-4">{{ substr($schedule->jam_mulai, 0, 5) }} - {{ substr($schedule->jam_selesai, 0, 5) }}</td>
                                <td class="py-2 pr-4"><x-status-badge :status="$schedule->status" /></td>
                                <td class="py-2 whitespace-nowrap">
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" class="inline"
                                          onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-3 text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada jadwal.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $schedules->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
