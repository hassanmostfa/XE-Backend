<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    // Get All Audit Logs
    public function index()
    {
        $audit_logs = AuditLog::all();
        return response()->json([
            'audit_logs' => $audit_logs
        ] , 200);

    }

    // Add New Audit Log
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'action' => 'required',
            'user_ip' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $audit_log = AuditLog::create([
                'booking_id' => $request->booking_id,
                'action' => $request->action,
                'user_ip' => $request->user_ip
            ]);
            return response()->json([
                'message' => 'Audit log created successfully',
                'audit_log' => $audit_log
            ], 201);
        } catch (\Throwable $th) {
            return response(['message' => $th->getMessage()], 500);
        }
    }

    // Show Audit Log Details
    public function show($id)
    {
        return AuditLog::find($id);
    }

    // Update Audit Log
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'action' => 'required',
            'user_ip' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $audit_log = AuditLog::find($id);
            $audit_log->booking_id = $request->booking_id;
            $audit_log->action = $request->action;
            $audit_log->user_ip = $request->user_ip;
            $audit_log->save();
            return response()->json([
                'message' => 'Audit log updated successfully',
                'audit_log' => $audit_log
            ], 201);
        } catch (\Throwable $th) {
            return response(['message' => $th->getMessage()], 500);
        }
    }

    // Delete Audit Log
    public function destroy($id)
    {
        try{
            $audit_log = AuditLog::find($id);
        $audit_log->delete();
        return response()->json([
            'message' => 'Audit log deleted successfully'
        ], 200);
        } catch (\Throwable $th) {
            return response(['message' => $th->getMessage()], 500);
        }
    }
}
