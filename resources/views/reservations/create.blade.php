@extends('layouts.app')

@section('title', 'Create Reservation')

@section('content')
    <div class="container mx-auto py-12">
        <div class="max-w-lg mx-auto bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold mb-6">Create a Reservation</h1>
            <form action="{{ route('reservations.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="hotel_id" class="block text-sm font-medium text-gray-700">Hotel</label>
                    <select name="hotel_id" id="hotel_id" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                        <option value="">Select a hotel</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="room_id" class="block text-sm font-medium text-gray-700">Room</label>
                    <select name="room_id" id="room_id" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                        <option value="">Select a room</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="check_in_date" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                    <input type="date" name="check_in_date" id="check_in_date" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                </div>
                <div>
                    <label for="check_out_date" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                    <input type="date" name="check_out_date" id="check_out_date" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600" required>
                </div>
                <div>
                    <label for="guests" class="block text-sm font-medium text-gray-700">Guests</label>
                    <input type="number" name="guests" id="guests" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600" min="1" required>
                </div>
                <div>
                    <label for="total_price" class="block text-sm font-medium text-gray-700">Total Price</label>
                    <input type="number" name="total_price" id="total_price" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600" step="0.01" min="0" required>
                </div>
                <div>
                    <label for="special_requests" class="block text-sm font-medium text-gray-700">Special Requests</label>
                    <textarea name="special_requests" id="special_requests" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-600"></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 transition">Create Reservation</button>
            </form>
        </div>
    </div>
@endsection