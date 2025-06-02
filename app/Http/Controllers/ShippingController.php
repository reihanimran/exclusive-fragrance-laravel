<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipping;

class ShippingController extends Controller
{
    public function edit()
    {
        $shipping = Auth::user()->shipping;
        return view('profile.shipping', compact('shipping'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();

        // Create or update
        $shipping = $user->shipping ?: new Shipping(['user_id' => $user->id]);
        $shipping->fill($data);
        $shipping->user_id = $user->id;
        $shipping->save();

        return redirect()->route('dashboard')->with('success', 'Shipping information updated.');
    }
}
