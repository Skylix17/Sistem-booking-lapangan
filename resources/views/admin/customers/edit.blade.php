<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Customer</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                @include('admin.customers._form', [
                    'action'   => route('admin.customers.update', $customer),
                    'method'   => 'PUT',
                    'customer' => $customer,
                ])
            </div>
        </div>
    </div>
</x-app-layout>
