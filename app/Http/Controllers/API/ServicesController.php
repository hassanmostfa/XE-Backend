<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceFeature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'price' => 'required|numeric',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'features' => 'nullable|array', // Ensure features is an array
            'features.*.title' => 'required|string', // Validate each feature title
            'features.*.description' => 'required|string', // Validate each feature description
        ]);
    
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
    
        try {
            // Start a database transaction
            DB::beginTransaction();
    
            // Store the service data
            $service = Service::create([
                'country_id' => $request->country_id,
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $request->file('image') ? $request->file('image')->store('services_images') : null,
            ]);
    
            // Store the service features
            if ($request->has('features')) {
                foreach ($request->features as $feature) {
                    $service->features()->create([
                        'title' => $feature['title'],
                        'description' => $feature['description'],
                    ]);
                }
            }
    
            // Commit the transaction
            DB::commit();
    
            return response()->json([
                'message' => 'Service created successfully',
                'service' => $service,
            ], 201);
    
        } catch (\Throwable $th) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            return response(['message' => $th->getMessage()], 500);
        }
    }
    


    // Show Service Details
    public function show($id)
    {
        try{
            $service = Service::with('features')->find($id);
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
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'features' => 'array',
            'features.*.title' => 'required|string',
            'features.*.description' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
    
        try {
            $service = Service::findOrFail($id); // Use findOrFail to throw an exception if not found
    
            // Update the service properties
            $service->country_id = $request->country_id;
            $service->title = $request->title;
            $service->description = $request->description;
            $service->price = $request->price;
    
            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($service->image) {
                    Storage::delete($service->image); // Ensure the correct path is provided here
                }
    
                // Store the new image and update the service image path
                $service->image = $request->file('image')->store('services_images');
            }
    
            $service->save(); // Save the updated service
    
            // Handle service features
            if ($request->has('features')) {
                // Update existing features or create new ones
                foreach ($request->features as $featureData) {
                    // You can customize this logic based on your requirements
                    $features = $service->features;
                    foreach ($request->features as $index => $featureData) {
                        $feature = $features[$index];
                        $feature->title = $featureData['title'];
                        $feature->description = $featureData['description'];
                        $feature->save();
                    }
                }
            }
    
            return response()->json([
                'message' => 'Service updated successfully',
                'service' => $service
            ], 200);
        } catch (\Exception $e) {
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
