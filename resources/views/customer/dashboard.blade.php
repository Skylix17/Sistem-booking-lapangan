<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard Customer</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Cari lapangan dan lakukan booking di sini.</p>

                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('customer.fields.index') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Cari Lapangan</a>
                    <a href="{{ route('customer.bookings.index') }}" class="rounded-md bg-gray-700 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-600">Booking Saya</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
