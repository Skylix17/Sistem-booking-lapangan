<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    // Daftar customer, yang terakhir login tampil paling atas
    public function index(Request $request)
    {
        $customers = User::where('role', 'customer')
            ->withCount('bookings')
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($w) use ($request) {
                    $w->where('name', 'like', '%' . $request->q . '%')
                      ->orWhere('email', 'like', '%' . $request->q . '%');
                });
            })
            ->orderByRaw('last_login_at IS NULL')
            ->orderByDesc('last_login_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    // Detail customer + riwayat bookingnya
    public function show(User $customer)
    {
        $this->ensureCustomer($customer);

        $bookings = $customer->bookings()
            ->with('schedule.field')
            ->latest()
            ->get();

        return view('admin.customers.show', compact('customer', 'bookings'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'status'   => ['required', Rule::in(['active', 'inactive'])],
        ]);

        // role selalu customer; password di-hash otomatis oleh cast pada model User
        $customer = new User([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'role'     => 'customer',
            'status'   => $validated['status'],
        ]);
        $customer->email_verified_at = now();
        $customer->save();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil ditambahkan.');
    }

    public function edit(User $customer)
    {
        $this->ensureCustomer($customer);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $this->ensureCustomer($customer);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($customer->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'status'   => ['required', Rule::in(['active', 'inactive'])],
        ]);

        // password hanya diganti jika diisi
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Data customer berhasil diperbarui.');
    }

    public function destroy(User $customer)
    {
        $this->ensureCustomer($customer);

        // Booking ikut terhapus (cascade) jika user dihapus, jadi dicegah agar riwayat transaksi aman
        if ($customer->bookings()->exists()) {
            return back()->with(
                'error',
                'Customer masih memiliki riwayat booking. Ubah status menjadi Nonaktif.'
            );
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil dihapus.');
    }

    // Hanya akun ber-role customer yang boleh dikelola lewat controller ini
    private function ensureCustomer(User $user): void
    {
        abort_unless($user->role === 'customer', 404);
    }
}
