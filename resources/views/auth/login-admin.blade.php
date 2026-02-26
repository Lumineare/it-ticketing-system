<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - IT Ticketing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border-t-4 border-indigo-600">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Login Staff IT</h2>
            <p class="text-sm text-gray-500 mt-2">Silakan masuk untuk mengelola tiket</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email Admin</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                       id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="admin@it.com">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" 
                       id="password" type="password" name="password" required placeholder="********">
            </div>

            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150" type="submit">
                Masuk Dashboard
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('tickets.public.create') }}" class="text-sm text-gray-500 hover:text-indigo-600">
                &larr; Kembali ke Form Lapor Masalah
            </a>
        </div>
        
        <div class="mt-4 pt-4 border-t text-xs text-gray-400 text-center">
            <p>Default: admin@it.com / password</p>
        </div>
    </div>

</body>
</html>