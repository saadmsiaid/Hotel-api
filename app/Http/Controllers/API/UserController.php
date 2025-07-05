<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;
use Illuminate\Foundation\Auth\AuthorizesRequests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AccessAuthorizesRequests; // Add this trait

    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $user->update($validated);

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}