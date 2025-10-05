<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900">
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="text-lg font-bold">Shopify Integration</div>
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
            <a href="{{ route('shopify.products') }}" class="text-blue-600 hover:underline">Productos</a>
            <a href="{{ route('shopify.orders30d') }}" class="text-blue-600 hover:underline">Órdenes</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-red-600 hover:underline">Logout</button>
            </form>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>