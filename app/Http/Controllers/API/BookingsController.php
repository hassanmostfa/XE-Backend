<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    // Get all Bookings
    public function index() {
        $bookings = Booking::with('service')->get();
        return response()->json([
            'bookings' => $bookings
        ], 200);
    }


    // Create a new Booking
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
        'client_name' => 'required',
        'client_email' => 'required',
        'client_phone' => 'required',
        'service_id' => 'required',
        'notes'  => 'nullable|string',
        'payment_status' => 'required',
        'payment_gate' => 'required',
        'booking_status' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        try{
            $booking = Booking::create([
                'client_name' => $request->client_name,
                'client_email' => $request->client_email,
                'client_phone' => $request->client_phone,
                'service_id' => $request->service_id,
                'notes' => $request->notes,
                'payment_status' => $request->payment_status,
                'payment_gate' => $request->payment_gate,
                'booking_status' => $request->booking_status
            ]);
            return response()->json([
                'message' => 'Booking created successfully',
                'booking' => $booking
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


// Show Booking Details
public function show($id) {
    try{
        $booking = Booking::find($id);
        return response()->json([
            'booking' => $booking
        ], 200);
    }catch(\Exception $e){
        return response()->json([
            'message' => $e->getMessage()
        ], 500);
    }
}


// Update Booking
public function update(Request $request, $id) {
    $validator = Validator::make($request->all(), [
    'client_name' => 'required',
    'client_email' => 'required',
    'client_phone' => 'required',
    'service_id' => 'required',
    'notes'  => 'nullable|string',
    'payment_status' => 'required',
    'payment_gate' => 'required',
    'booking_status' => 'required',
    ]);
    if ($validator->fails()) {
        return response(['errors'=>$validator->errors()->all()], 422);
    }
    try{
        $booking = Booking::find($id);
        $booking->update([
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'service_id' => $request->service_id,
            'notes' => $request->notes,
            'payment_status' => $request->payment_status,
            'payment_gate' => $request->payment_gate,
            'booking_status' => $request->booking_status
        ]);
        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ], 201);
    }catch(\Exception $e){
        return response()->json([
            'message' => $e->getMessage()
        ], 500);
    }
}

    // Destroy Booking
    public function destroy($id) {
        try{
            $booking = Booking::find($id);
            $booking->delete();
            return response()->json([
                'message' => 'Booking deleted successfully'
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
