<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Faq;

class FaqController extends Controller
{
    // Get all faqs
    public function index()
    {
        try {
            $faqs = Faq::all();
            return response()->json(['status' => 'success','faqs' => $faqs ], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }

    // Add New Faq
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255', 
            'answer' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $faq = new Faq();
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->save();
            return response()->json([
                'status' => 'success',
                'message' => 'تمت الاضافة بنجاح',
                'faq' => $faq
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }

    // Show Faq Details
    public function show($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            return response()->json(['status' => 'success','faq' => $faq ], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }

    // Update Faq
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $faq = Faq::findOrFail($id);
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->save();
            return response()->json([
                'status' => 'success',
                'message' => 'تم التعديل بنجاح',
                'faq' => $faq
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }

    // Delete Faq
    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'تم الحذف بنجاح',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }
}
