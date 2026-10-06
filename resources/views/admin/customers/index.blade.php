<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Data Customer</h2>
            <a href="{{ route('admin.customers.create') }}"
               class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-indigo-500">
                + Tambah Customer
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <form method="GET" class="mb-5 flex items-center gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email"
                       class="w-64 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                <x-primary-button>Cari</x-primary-button>
            </form>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-left text-xs uppercase text-gray-500">
                            <th class="py-2 pr-4">Nama</th>
                            <th class="py-2 pr-4">Email</th>
                            <th class="py-2 pr-4">Terdaftar</th>
                            <th class="py-2 pr-4">Terakhir Login</th>
                            <th class="py-2 pr-4">Booking</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="py-2 pr-4 font-medium">{{ $customer->name }}</td>
                                <td class="py-2 pr-4">{{ $customer->email }}</td>
                                <td class="py-2 pr-4">{{ $customer->created_at->format('d/m/Y') }}</td>
                                <td class="py-2 pr-4">
                                    @if ($customer->last_login_at)
                                        {{ $customer->last_login_at->format('d/m/Y H:i') }}
                                        <div class="text-xs text-gray-500">{{ $customer->last_login_at->diffForHumans() }}</div>
                                    @else
                                        <span class="text-gray-500">Belum pernah login</span>
                                    @endif
                                </td>
                                <td class="py-2 pr-4">{{ $customer->bookings_count }}</td>
                                <td class="py-2 pr-4"><x-status-badge :status="$customer->status" /></td>
                                <td class="py-2">
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="text-gray-600 dark:text-gray-300 hover:underline">Detail</a>
                                    <a href="{{ route('admin.customers.edit', $customer) }}" class="ml-3 text-indigo-600 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="inline"
                                          onsubmit="return confirm('Hapus customer ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-3 text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-6 text-center text-gray-500">Belum ada customer.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $customers->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
