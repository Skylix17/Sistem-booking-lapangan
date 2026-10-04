@props(['keys' => []])

@if (session('success'))
    <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 rounded-md bg-red-100 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
@endif
@foreach ($keys as $key)
    @error($key)
        <div class="mb-4 rounded-md bg-red-100 px-4 py-3 text-sm text-red-800">{{ $message }}</div>
    @enderror
@endforeach
