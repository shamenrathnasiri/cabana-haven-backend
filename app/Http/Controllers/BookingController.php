<?php

namespace App\Http\Controllers;

use App\Models\booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = booking::all();
        return response()->json($bookings, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'initials' => 'required|string|max:10',
            'idNumber' => 'required|string|max:20',
            'contactNumber' => 'required|string|max:15',
            'guests' => 'required|integer|min:1',
            'room' => 'required|string|max:100',
            'checkIn' => 'required|date',
            'checkOut' => 'required|date|after:checkIn',
            'status' => 'sometimes|string|in:check_in,check_out,not_came',
        ]);

        $booking = booking::create([
            'name' => $validated['name'],
            'intials' => $validated['initials'],
            'identiy_number' => $validated['idNumber'],
            'contact' => $validated['contactNumber'],
            'number_of_guest' => $validated['guests'],
            'room_type' => $validated['room'],
            'checking_date' => $validated['checkIn'],
            'checkout_date' => $validated['checkOut'],
            'status' => $validated['status'] ?? 'not_came',
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(booking $booking)
    {
        return response()->json($booking, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, booking $booking)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'initials' => 'sometimes|string|max:10',
            'idNumber' => 'sometimes|string|max:20',
            'contactNumber' => 'sometimes|string|max:15',
            'guests' => 'sometimes|integer|min:1',
            'room' => 'sometimes|string|max:100',
            'checkIn' => 'sometimes|date',
            'checkOut' => 'sometimes|date|after:checkIn',
            'status' => 'sometimes|string|in:check_in,check_out,not_came',
        ]);

        $updateData = [];
        if (isset($validated['name'])) $updateData['name'] = $validated['name'];
        if (isset($validated['initials'])) $updateData['intials'] = $validated['initials'];
        if (isset($validated['idNumber'])) $updateData['identiy_number'] = $validated['idNumber'];
        if (isset($validated['contactNumber'])) $updateData['contact'] = $validated['contactNumber'];
        if (isset($validated['guests'])) $updateData['number_of_guest'] = $validated['guests'];
        if (isset($validated['room'])) $updateData['room_type'] = $validated['room'];
        if (isset($validated['checkIn'])) $updateData['checking_date'] = $validated['checkIn'];
        if (isset($validated['checkOut'])) $updateData['checkout_date'] = $validated['checkOut'];
        if (isset($validated['status'])) $updateData['status'] = $validated['status'];

        $booking->update($updateData);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(booking $booking)
    {
        $booking->delete();
        return response()->json([
            'message' => 'Booking deleted successfully'
        ], 200);
    }
}
