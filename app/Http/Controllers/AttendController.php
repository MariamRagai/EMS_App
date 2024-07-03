<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Location;
use Carbon\Carbon;

class AttendController extends Controller
{
    public function checkIn(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|integer',
            'Latitude' => 'required|numeric',
            'Longitude' => 'required|numeric'
        ]);

        // Fetch the location coordinates from the database
        $location = Location::where('id',1)->first(); // Assuming there is only one location record


        // Calculate the distance between the given coordinates and the saved location
        $distance = $this->calculateDistance($location->Latitude, $location->Longitude, $request->Latitude, $request->Longitude);

        // Define the acceptable distance (e.g., within 50 meters)
        $acceptableDistance = 50;

        if ($distance > $acceptableDistance) {
            return response()->json([
                'message' => 'You are not within the acceptable range of the location',
            ], 400);
        }
        $now = Carbon::now();
        // Create a new attendance record
        $attendance = Attendance::create([
            'user_id' => $request->user_id,
            'Attendance_time' => $now->format('H:i:s'),
            'Day_date' => $now->format('Y-m-d l')
        ]);

        return response()->json([
            'message' => 'Check-in recorded successfully',

        ], 201);
    }

    public function checkOut(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|integer',
        ]);
        $now = Carbon::now();
        // Find the attendance record for the current day
        $attendance = Attendance::where('user_id', $request->user_id)
                                ->whereDate('Day_date', $now->format('Y-m-d l'))
                                ->first();

        if (!$attendance) {
            return response()->json([
                'message' => 'Attendance record not found for today'
            ], 404);
        }

        // Update the departure time
        $attendance->update([
            'Departure_time' =>$now->format('H:i:s')
        ]);

        return response()->json([
            'message' => 'Check-out recorded successfully',
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Distance in meters
    }
}
