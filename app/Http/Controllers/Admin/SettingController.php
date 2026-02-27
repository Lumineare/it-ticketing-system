<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        // Opsional: Paksa cek admin di sini juga
        // if (Auth::user()->role !== 'admin') abort(403);
    }

    // --- UNIT ---
    public function units()
    {
        $units = Unit::latest()->get();
        return view('admin.settings.units', compact('units'));
    }

    public function storeUnit(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:units,name']);
        Unit::create(['name' => $request->name]);
        return back()->with('success', 'Unit berhasil ditambahkan.');
    }

    public function deleteUnit($id)
    {
        Unit::destroy($id);
        return back()->with('success', 'Unit dihapus.');
    }

    // --- TEKNISI ---
    public function technicians()
    {
        $technicians = User::whereIn('role', ['admin', 'teknisi'])->latest()->get();
        return view('admin.settings.technicians', compact('technicians'));
    }

    public function storeTechnician(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return back()->with('success', 'Teknisi berhasil ditambahkan.');
    }
    
    public function deleteTechnician($id)
    {
        if ($id == Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        User::destroy($id);
        return back()->with('success', 'Teknisi dihapus.');
    }
}