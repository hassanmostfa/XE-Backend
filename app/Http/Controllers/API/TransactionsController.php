<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
class TransactionsController extends Controller
{
    // Get all Transactions with client_name and service_name
    public function index() {
        // Eager load 'booking' and its related 'service'
        $transactions = Transaction::with(['booking:id,client_name,service_id', 'booking.service:id,title'])->get();

        return response()->json([
            'transactions' => $transactions
        ], 200);
    }



    // Create a new Transaction
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
        'booking_id' => 'required',
        'amount' => 'required',
        'payment_status' => 'required',
        'payment_method' => 'required',
        'transaction_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        try{
            $transaction = Transaction::create([
                'booking_id' => $request->booking_id,
                'amount' => $request->amount,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id
            ]);
            return response()->json([
                'message' => 'Transaction created successfully',
                'transaction' => $transaction
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Show Transaction Details
    public function show($id) {
        try{
            $transaction = Transaction::find($id);
            return response()->json([
                'transaction' => $transaction
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Update Transaction
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
        'booking_id' => 'required',
        'amount' => 'required',
        'payment_status' => 'required',
        'payment_method' => 'required',
        'transaction_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        try{
            $transaction = Transaction::find($id);
            $transaction->update([
                'booking_id' => $request->booking_id,
                'amount' => $request->amount,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id    
            ]);
            return response()->json([
                'message' => 'Transaction updated successfully',
                'transaction' => $transaction
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Destroy Transaction
    public function destroy($id) {
        try{
            $transaction = Transaction::find($id);
            $transaction->delete();
            return response()->json([
                'message' => 'Transaction deleted successfully'
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
