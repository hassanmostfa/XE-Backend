<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
             // Get all services
        $services = Service::all();

        return response()->json($services);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Store Service
    public function store(Request $request)
    {
        // Add New Service
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

      try {
        $service = Service::create([
            'country_id' => $request->country_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service,
        ], 201);
      } catch (\Throwable $th) {
        return response(['message' => $th->getMessage()], 500);
      }
    }


    // Show Service Details
    public function show($id)
    {
        try{
            $service = Service::find($id);
            return response()->json($service);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }


    // Update Service
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        try{
            $service = Service::find($id);
            $service->update([
                'country_id' => $request->country_id,
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price
            ]);
            return response()->json([
                'message' => 'Service updated successfully',
                'service' => $service
            ], 201);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
            }
    }

    // Destroy Service
    public function destroy ($id) {
        try{
            $service = Service::find($id);
            $service->delete();
            return response()->json(['message' => 'Service deleted successfully'], 200);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }


}
