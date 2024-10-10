<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;

class MessagesController extends Controller
{
    // get all messages
    public function index()
    {
        try {
            $messages = Message::all();
            return response()->json([
                'messages' => $messages
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Add New Message
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $message = Message::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'message' => $request->message
            ]);
            return response()->json([
                'message' => 'Message created successfully',
                'message' => $message
            ], 201);
        } catch (\Throwable $th) {
            return response(['message' => $th->getMessage()], 500);
        }
    }

    // Show Message Details
    public function show($id)
    {
       try {
        $message = Message::find($id);
        return response()->json([
            'message' => $message
        ], 200);
       } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 500);
       }
    }

    // Update Message
    public function update(Request $request, $id)
    {
        try {
            $message = Message::find($id);
            $message->name = $request->name;
            $message->phone = $request->phone;
            $message->message = $request->message;
            $message->save();
            return response()->json([
                'message' => 'Message updated successfully',
                'message' => $message
            ], 201);
        } catch (\Throwable $th) {
            return response(['message' => $th->getMessage()], 500);
        }
    }

    // Delete Message
    public function destroy($id)
    {
        try {
            $message = Message::find($id);
            $message->delete();
            return response()->json([
                'message' => 'Message deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response(['message' => $th->getMessage()], 500);
        }
    }
}
