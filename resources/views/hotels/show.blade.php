@extends('layouts.app')

@section('title', $hotel->name)

@section('content')
    <div class="container mx-auto py-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="{{ $hotel->image ?? 'https://images.unsplash.com/photo-1542314831-8d7c6b875a4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $hotel->name }}" class="w-full h-64 object-cover">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-4">{{ $hotel->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $hotel->description }}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <p><strong>Address:</strong> {{ $hotel->address }}</p>
                    <p><strong>City:</strong> {{ $hotel->city }}</p>
                    <p><strong>Country:</strong> {{ $hotel->country }}</p>
                    <p><strong>Rating:</strong> {{ $hotel->rating }}/5</p>
                </div>
                <a href="{{ route('reservations.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition">Book Now</a>
            </div>
        </div>
    </div>
@endsection