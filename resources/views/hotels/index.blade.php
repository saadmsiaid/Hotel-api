@extends('layouts.app')

@section('title', 'Hotels')

@section('content')
    <!-- Hero Section -->
    <div class="hero-bg h-96 flex items-center justify-center text-white text-center">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Discover Your Perfect Stay</h1>
            <p class="text-lg md:text-xl mb-6">Explore luxury hotels worldwide with Hotel Haven</p>
            <a href="#hotels" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition">Browse Hotels</a>
        </div>
    </div>

    <!-- Hotels List -->
    <section id="hotels" class="container mx-auto py-12">
        <h2 class="text-3xl font-bold mb-8 text-center">Our Hotels</h2>
        @if ($hotels->isEmpty())
            <p class="text-center text-gray-600">No hotels found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($hotels as $hotel)
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg card-hover transition transform">
                        <img src="{{ $hotel->image ?? 'https://images.unsplash.com/photo-1542314831-8d7c6b875a4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" alt="{{ $hotel->name }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $hotel->name }}</h3>
                            <p class="text-gray-600 mb-2">{{ $hotel->city }}, {{ $hotel->country }}</p>
                            <p class="text-gray-600 mb-4">Rating: {{ $hotel->rating }}/5</p>
                            <a href="{{ route('hotels.show', $hotel) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection