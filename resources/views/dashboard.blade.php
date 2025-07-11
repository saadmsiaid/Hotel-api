@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold mb-6">Welcome, {{ $user->name }}</h1>
        <div class="bg-white rounded-lg shadow-lg p-6">
            <p class="text-gray-600 mb-4">Email: {{ $user->email }}</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('reservations.index') }}" class="bg-blue-600 text-white p-4 rounded-md hover:bg-blue-700 transition text-center">View My Reservations</a>
                <a href="{{ route('payments.index') }}" class="bg-blue-600 text-white p-4 rounded-md hover:bg-blue-700 transition text-center">View My Payments</a>
                <a href="{{ route('reviews.index') }}" class="bg-blue-600 text-white p-4 rounded-md hover:bg-blue-700 transition text-center">View My Reviews</a>
                @if (auth()->user()->role === 'super_admin' || auth()->user()->role === 'hotel_manager')
                    <a href="{{ route('admin.hotels.index') }}" class="bg-green-600 text-white p-4 rounded-md hover:bg-green-700 transition text-center">Admin Dashboard</a>
                @endif
            </div>
        </div>
    </div>
@endsection