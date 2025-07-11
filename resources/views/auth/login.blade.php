@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container mx-auto py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold mb-6 text-center">Login to Your Account</h1>
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 transition">Login</button>
            </form>
            <p class="mt-4 text-center text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a></p>
        </div>
    </div>
@endsection