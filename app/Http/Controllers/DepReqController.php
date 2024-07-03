<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartureRequest;

class DepReqController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'Departure_time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:255',
        ]);

        $Departure_Request = DepartureRequest::create([
            'user_id' => $request->user_id,
            'Departure_time' => $request->Departure_time,
            'reason' => $request->reason,
        ]);

        return response()->json([
            'message' => 'Request created successfully!',
            'data' =>$Departure_Request,
        ], 201);
    }

}
