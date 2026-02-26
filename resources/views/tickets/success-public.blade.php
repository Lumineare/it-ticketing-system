<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Terkirim</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md text-center max-w-md w-full">
        <div class="text-green-500 text-5xl mb-4">✓</div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Laporan Terkirim!</h2>
        <p class="text-gray-600 mb-6">Terima kasih. Tim IT telah menerima laporan Anda dan akan segera menindaklanjuti.</p>
        <a href="{{ route('tickets.public.create') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Buat Laporan Lain</a>
    </div>
</body>
</html>