# 🎫 IT Ticketing System

Sistem manajemen tiket bantuan IT (Helpdesk) yang modern, responsif, dan mudah digunakan. Sistem ini memungkinkan karyawan untuk melaporkan masalah teknis tanpa perlu login, sementara tim IT dapat mengelola, melacak, dan menyelesaikan laporan tersebut melalui dashboard admin yang aman.

Dibangun menggunakan **Laravel 12** dan **Tailwind CSS**, sistem ini dirancang untuk efisiensi alur kerja dukungan teknis dengan antarmuka yang bersih dan natural.

## ✨ Fitur Utama

### 🚀 Untuk Pengguna Umum (Tanpa Login)
- **Pelaporan Cepat**: Buat tiket laporan masalah hanya dengan mengisi nama, email, dan deskripsi masalah. Tidak perlu registrasi akun.
- **Kode Pelacakan Unik**: Setiap laporan mendapatkan kode unik (misal: `TKT-250226-A1B2`) untuk memantau status.
- **Transparansi Status Real-time**: Pengguna dapat melihat daftar semua tiket dan статус pengerjaannya secara langsung di halaman utama.
- **Riwayat Detail**: Melihat detail progres, catatan teknisi, dan waktu penyelesaian (Start Date & End Date).

### 🛡️ Untuk Admin / Tim IT
- **Autentikasi Aman**: Login khusus staf IT dengan perlindungan role-based access.
- **Dashboard Manajemen**: Lihat semua tiket masuk dalam format tabel yang rapi (No, Kode, Tanggal, Deskripsi, Status, Note, dll).
- **Update Status Progres**: Ubah status tiket (Open, In Progress, Resolved, Closed) dengan satu klik.
- **Catatan Teknisi**: Tambahkan catatan perbaikan yang langsung terlihat oleh pelapor.
- **Penugasan Otomatis**: Tugaskan tiket ke teknisi tertentu.
- **Auto End Date**: Waktu penyelesaian tercatat otomatis saat status diubah menjadi "Resolved" atau "Closed".

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12.x (PHP 8.3+)
- **Frontend**: Blade Templates + Tailwind CSS (via CDN)
- **Database**: MySQL
- **Server Lokal**: Laragon (Windows)
- **Version Control**: Git & GitHub

## 📸 Screenshots

*(Opsional: Kamu bisa menambahkan screenshot nanti setelah kamu upload gambar ke repo)*
> Tampilan Dashboard Publik & Panel Admin yang bersih dan responsif.

## 🚀 Instalasi & Menjalankan Proyek

Ikuti langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda (menggunakan Laragon):

### 1. Prasyarat
Pastikan Anda telah menginstall:
- [Laragon](https://laragon.org/) (atau XAMPP/WAMP dengan PHP 8.3+)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)

### 2. Kloning Repository
```bash
git clone https://github.com/Lumineare/it-ticketing-system.git
cd it-ticketing-system