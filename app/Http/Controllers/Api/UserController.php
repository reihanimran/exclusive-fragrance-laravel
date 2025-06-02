<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get authenticated user profile with relationships.
     */
    public function profile(Request $request)
    {
        $user = $request->user()->load(['shipping', 'orders', 'activeCartItems.product']);
        return response()->json($user);
    }

    /**
     * Update authenticated user profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'date_of_birth' => 'nullable|date',
            'contact_number' => 'nullable|string|max:15',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ]);
    }

    /**
     * Get the user’s order history.
     */
    public function orders(Request $request)
    {
        return response()->json($request->user()->orders()->with('items.product')->latest()->get());
    }
}
