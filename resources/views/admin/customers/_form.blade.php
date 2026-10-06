{{-- Variabel: $action, $method (opsional), $customer (null saat tambah) --}}
@php
    $inputClass = 'mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-5">
    @csrf
    @isset($method) @method($method) @endisset

    <div>
        <x-input-label for="name" value="Nama" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $customer?->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $customer?->email)" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password" :value="$customer ? 'Password Baru (kosongkan jika tidak diganti)' : 'Password'" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                      autocomplete="new-password" :required="! $customer" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="status" value="Status Akun" />
        <select id="status" name="status" class="{{ $inputClass }}">
            <option value="active" @selected(old('status', $customer?->status ?? 'active') === 'active')>Aktif</option>
            <option value="inactive" @selected(old('status', $customer?->status) === 'inactive')>Nonaktif</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div class="flex items-center gap-3 pt-2">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
    </div>
</form>
