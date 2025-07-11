<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Haven - @yield('title', 'Home')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-bg {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1445019980597-93fa8acb246c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-blue-900 text-white shadow-lg">
        <nav class="container mx-auto p-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold">Hotel Haven</a>
            <div class="space-x-4">
                <a href="{{ route('hotels.index') }}" class="hover:text-blue-300">Hotels</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-300">Dashboard</a>
                    @if (auth()->user()->role === 'super_admin' || auth()->user()->role === 'hotel_manager')
                        <a href="{{ route('admin.hotels.index') }}" class="hover:text-blue-300">Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-300">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-300">Login</a>
                    <a href="{{ route('register') }}" class="hover:text-blue-300">Register</a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar for Authenticated Users -->
        @auth
            <aside class="w-64 bg-blue-800 text-white h-screen fixed top-0 left-0 p-4 sidebar @if(!Request::is('dashboard*', 'reservations*', 'payments*', 'reviews*')) sidebar-hidden @endif">
                <h2 class="text-xl font-semibold mb-4">My Account</h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('dashboard') }}" class="block p-2 hover:bg-blue-700 rounded">Dashboard</a></li>
                    <li><a href="{{ route('reservations.index') }}" class="block p-2 hover:bg-blue-700 rounded">Reservations</a></li>
                    <li><a href="{{ route('payments.index') }}" class="block p-2 hover:bg-blue-700 rounded">Payments</a></li>
                    <li><a href="{{ route('reviews.index') }}" class="block p-2 hover:bg-blue-700 rounded">Reviews</a></li>
                    @if (auth()->user()->role === 'super_admin' || auth()->user()->role === 'hotel_manager')
                        <li><a href="{{ route('admin.hotels.index') }}" class="block p-2 hover:bg-blue-700 rounded">Admin Dashboard</a></li>
                    @endif
                </ul>
            </aside>
        @endauth

        <!-- Content Area -->
        <main class="flex-1 p-4 @auth ml-64 @endif">
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4 max-w-2xl mx-auto">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4 max-w-2xl mx-auto">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white p-4 text-center">
        <p>&copy; {{ date('Y') }} Hotel Haven. All rights reserved.</p>
        <div class="mt-2 space-x-4">
            <a href="#" class="hover:text-blue-300">Privacy Policy</a>
            <a href="#" class="hover:text-blue-300">Terms of Service</a>
            <a href="#" class="hover:text-blue-300">Contact Us</a>
        </div>
    </footer>
</body>
</html>