<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as AccessAuthorizesRequests;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
        use AccessAuthorizesRequests;
    public function index()
    {
        return AdminResource::collection(Admin::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Admin::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
            'role' => 'required|in:super_admin,hotel_manager',
            'hotel_id' => 'nullable|exists:hotels,id',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $admin = Admin::create($validated);
        return new AdminResource($admin);
    }

    public function show(Admin $admin)
    {
        return new AdminResource($admin);
    }

    public function update(Request $request, Admin $admin)
    {
        $this->authorize('update', $admin);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'sometimes|string|min:8',
            'role' => 'sometimes|in:super_admin,hotel_manager',
            'hotel_id' => 'nullable|exists:hotels,id',
            'status' => 'sometimes|in:active,inactive',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $admin->update($validated);
        return new AdminResource($admin);
    }

    public function destroy(Admin $admin)
    {
        $this->authorize('delete', $admin);
        $admin->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }
}