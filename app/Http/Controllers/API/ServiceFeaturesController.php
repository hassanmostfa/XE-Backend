<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceFeature;

use Illuminate\Support\Facades\Validator;



class ServiceFeaturesController extends Controller
{
    
    // Get all service features
    public function index()
    {
        $service_features = ServiceFeature::all();
        return response()->json($service_features, 200);
    }

    // Get All Features of a service
    public function serviceFeatures($id)
    {
        $service_features = ServiceFeature::where('service_id', $id)->get();
        return response()->json($service_features, 200);
    }

    // Store service feature
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $service_feature = ServiceFeature::create([
                'service_id' => $request->service_id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return response()->json([
                'message' => 'Service feature created successfully',
                'service_feature' => $service_feature,
            ], 201);
        } catch (\Throwable $th) {
            return response(['message' => $th->getMessage()], 500);
        }
    }

    // Show service feature details
    public function show($id)
    {
        try{
            $service_feature = ServiceFeature::find($id);
            return response()->json($service_feature);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }

    // Update service feature
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        try{
            $service_feature = ServiceFeature::find($id);
            $service_feature->update([
                'service_id' => $request->service_id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return response()->json([
                'message' => 'Service feature updated successfully',
                'service_feature' => $service_feature
            ], 201);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }

    // Destroy service feature
    public function destroy ($id) {
        try{
            $service_feature = ServiceFeature::find($id);
            $service_feature->delete();
            return response()->json(['message' => 'Service feature deleted successfully'], 200);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }
}
