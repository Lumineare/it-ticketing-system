<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IT Helpdesk')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Navbar Minimalis -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('tickets.public.index') }}" class="font-bold text-xl text-indigo-700">IT Helpdesk</a>
            <div class="text-sm text-gray-500">
                Sistem Tiket Terpadu
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto py-6">
        <div class="max-w-5xl mx-auto px-4 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} IT Department. All rights reserved.
        </div>
    </footer>
</body>
</html>