<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar semua user yang memiliki peran sebagai teknisi.
     */
    public function index()
    {
        // Mengambil dari model User dengan filter kolom role = 'teknisi' 
        // Kemudian diurutkan secara alfabetis berdasarkan nama
        $users = \App\Models\User::where('role', 'teknisi')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan formulir pendaftaran teknisi baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan data pendaftaran teknisi baru dari formulir ke dalam file database hris.
     */
    public function store(Request $request)
    {
        // Validasi input: Nama dan Email sangat penting (wajib isian), serta Email harus unique.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Mendaftarkan role default sebagai teknisi langsung tanpa campur tangan form
        $validated['role'] = 'teknisi';
        
        // Memastikan password ter-enkripsi sebelum masuk di database menggunakan hashing \Hash::make
        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);

        // Mengirim instruksi Create ke eloquent base class model User
        \App\Models\User::create($validated);

        // Setelah berhasil dibuat, user diarahkan kembali ke halaman "List User"
        return redirect()->route('admin.users.index')->with('success', 'Teknisi berhasil ditambahkan!');
    }

    /**
     * Menghapus catatan teknisi dari database berdasarkan ID terkait. 
     */
    public function destroy($id)
    {
        // Menemukan user berdasarkan ID
        $user = \App\Models\User::findOrFail($id);
        
        // Verifikasi berlapis bahwa user yang akan dihapus BENAR berstatus teknisi
        // Ini melindungi akun Admin agar tidak terhapus tak sengaja
        if ($user->role === 'teknisi') {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Teknisi berhasil dihapus!');
        }
        
        // Jika yang dipilih adalah user administrator, blokir prosessnya
        return back()->with('error', 'Tidak dapat menghapus user ini.');
    }
}
