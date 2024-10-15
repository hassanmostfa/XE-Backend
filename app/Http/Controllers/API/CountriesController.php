<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class CountriesController extends Controller
{
    // Get all countries
    public function gatAllCountries()
    {
        try{
            $countries = Country::all();
            return response()->json($countries);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }


    // Add New Country
    public function addCountry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        try{
            $country = Country::create([
                'name' => $request->name,
                'image' => $request->file('image')->store('countries_images')
            ]);
            return response()->json($country, 201);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }


    // Show CountryDetails
    public function showCountryDetails($id)
    {
        try{
            $country = Country::find($id);
            return response()->json($country);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }

    // Update Country
    public function updateCountry(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }


    
        try {
            // Find the country by ID
            $country = Country::findOrFail($id);
    
            // Update the name
            $country->name = $request->name;
    
            // Check if an image is uploaded
            if ($request->hasFile('image')) {
                // Store the new image and update the 'image' field
                $country->image = $request->file('image')->store('countries_images');
            }
    
            // Save the updated country details
            $country->save();
    
            return response()->json($country, 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }
    

    // Delete Country
    public function deleteCountry($id)
    {
        try{
            $country = Country::find($id);
            $country->delete();
            return response()->json(['message' => 'Country deleted successfully'], 200);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }
}
