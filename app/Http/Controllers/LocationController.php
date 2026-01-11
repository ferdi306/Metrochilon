<?php

namespace App\Http\Controllers;

use App\Models\LocationPing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function ping(Request $request)
    {
        $data = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        LocationPing::create([
            'user_id' => Auth::id(),
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        return response()->json(['ok' => true]);
    }
}


