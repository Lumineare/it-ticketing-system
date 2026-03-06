<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MRT-IT')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex flex-col text-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 border-b border-gray-700 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span class="text-xl font-bold text-white tracking-tight">SI MRT (sistem informasi manajemen request trouble)</span>
                </div>
                
                <!-- Area Kanan (Login/Logout) -->
                <div class="flex items-center gap-4">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <!-- Form Logout -->
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 text-sm text-red-400 hover:text-red-300 font-medium transition px-3 py-2 rounded-lg hover:bg-red-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout
                                </button>
                            </form>
                        @else
                            <!-- Jika user biasa (jika ada) -->
                            <span class="text-sm text-gray-400">{{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-gray-400 hover:text-white transition">Logout</button>
                            </form>
                        @endif
                        @endauth
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-800 border-t border-gray-700 mt-auto py-6">
        <div class="max-w-5xl mx-auto px-4 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} all free to use.
        </div>
    </footer>
</body>
</html>