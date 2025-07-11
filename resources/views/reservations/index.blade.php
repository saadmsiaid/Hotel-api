@extends('layouts.app')

@section('title', 'My Reservations')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold mb-6">My Reservations</h1>
        <a href="{{ route('reservations.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition mb-6 inline-block">Make a Reservation</a>
        @if ($reservations->isEmpty())
            <p class="text-gray-600">No reservations found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($reservations as $reservation)
                    <div class="bg-white rounded-lg shadow-lg p-6 card-hover transition transform">
                        <p><strong>Hotel ID:</strong> {{ $reservation->hotel_id }}</p>
                        <p><strong>Room ID:</strong> {{ $reservation->room_id }}</p>
                        <p><strong>Check-in:</strong> {{ $reservation->check_in_date }}</p>
                        <p><strong>Check-out:</strong> {{ $reservation->check_out_date }}</p>
                        <p><strong>Guests:</strong> {{ $reservation->guests }}</p>
                        <p><strong>Total Price:</strong> ${{ $reservation->total_price }}</p>
                        <p><strong>Status:</strong> {{ $reservation->status }}</p>
                        <div class="mt-4 space-x-2">
                            <a href="{{ route('reservations.show', $reservation) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">View</a>
                            <a href="{{ route('reservations.edit', $reservation) }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">Edit</a>
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection