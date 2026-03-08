<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Menampilkan Tampilan View Login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menerima permintaan POST yang dikirimkan oleh form login
     * Metode ini mengecek apakah email dan sandi tersocokkan
     */
    public function login(Request $request)
    {
        // Check apabila input email dan password yang dikirim di form benar bentuknya
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Fungsi `Auth::attempt` akan melakukan query pada tabel users dan 
        // memeriksa kecocokan password dengan password dari database (otomatis di-hash jika cocok)
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            // Jika berhasil masuk, buat seksi baru (menghindari serangan security session fixation)
            $request->session()->regenerate();
            
            // Redirect ke halaman yang semula dituju, atau default ke dashboard Admin
            return redirect()->intended('dashboard');
        }

        // Jika salah password atau email, kembali ke form login dengan memunculkan Error validation manual
        return back()->withErrors([
            'email' => 'Kombinasi email atau password Anda tidak sesuai dengan rekaman.',
        ])->onlyInput('email');
    }

    /**
     * Tangani sistem operasi Logout, menghentikan session yang terhubung dan me-regenerate ke anonymous.
     */
    public function logout(Request $request)
    {
        // Fungsi auth::logout akan menghapus "auth state".
        \Illuminate\Support\Facades\Auth::logout();
        
        // Mematikan id dari sesi browser dan mengirim token CSRF baru.
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Arahkan kembali pengguna ke homepage dasar / landing portal pubilk (tanpa auth login)
        return redirect('/');
    }
}
