<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    // Halaman utama super admin: daftar semua lembaga + admin-nya
    public function index()
{
    $institutions = Institution::with('users')
        ->withCount('users')
        ->latest()
        ->get();

    return view('superadmin.index', compact('institutions'));
}

    // Simpan lembaga baru + akun admin-nya
    public function storeInstitution(Request $request)
    {
        $validated = $request->validate([
            'institution_name'  => 'required|string|max:255',
            'institution_email' => 'required|email|unique:institutions,email',
            'institution_phone' => 'nullable|string|max:20',
            'institution_address' => 'nullable|string',
            'admin_name'        => 'required|string|max:255',
            'admin_email'       => 'required|email|unique:users,email',
            'admin_password'    => 'required|min:8',
        ]);

        // Buat lembaga
        $institution = Institution::create([
            'name'    => $validated['institution_name'],
            'slug'    => Str::slug($validated['institution_name']) . '-' . Str::random(4),
            'email'   => $validated['institution_email'],
            'phone'   => $validated['institution_phone'] ?? null,
            'address' => $validated['institution_address'] ?? null,
        ]);

        // Buat akun admin untuk lembaga ini
        User::create([
            'name'           => $validated['admin_name'],
            'email'          => $validated['admin_email'],
            'password'       => Hash::make($validated['admin_password']),
            'role'           => 'admin',
            'institution_id' => $institution->id,
        ]);

        return back()->with('success', "Lembaga \"{$institution->name}\" berhasil ditambahkan.");
    }

    // Toggle aktif/nonaktif lembaga (dan semua admin-nya)
    public function toggleInstitution(Institution $institution)
    {
        $institution->update(['is_active' => !$institution->is_active]);
        $institution->users()->update(['is_active' => $institution->is_active]);

        $status = $institution->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Lembaga \"{$institution->name}\" berhasil {$status}.");
    }

    // Hapus lembaga beserta semua admin-nya
    public function destroyInstitution(Institution $institution)
    {
        $name = $institution->name;
        $institution->users()->delete();
        $institution->delete();
        return back()->with('success', "Lembaga \"{$name}\" berhasil dihapus.");
    }

    // Tambah admin baru ke lembaga yang sudah ada
    public function storeAdmin(Request $request, Institution $institution)
    {
        $validated = $request->validate([
            'admin_name'     => 'required|string|max:255',
            'admin_email'    => 'required|email|unique:users,email',
            'admin_password' => 'required|min:8',
        ]);

        User::create([
            'name'           => $validated['admin_name'],
            'email'          => $validated['admin_email'],
            'password'       => Hash::make($validated['admin_password']),
            'role'           => 'admin',
            'institution_id' => $institution->id,
        ]);

        return back()->with('success', 'Admin baru berhasil ditambahkan.');
    }

    // Hapus akun admin
    public function destroyAdmin(User $user)
    {
        $user->delete();
        return back()->with('success', 'Akun admin berhasil dihapus.');
    }
}