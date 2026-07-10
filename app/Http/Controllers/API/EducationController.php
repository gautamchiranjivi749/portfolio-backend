<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Models\Education;
use App\Http\Resources\EducationResource;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $educations = Education::orderBy('sort_order')->get();

       return response()->json([
        'success' => true,
        'data' => EducationResource::collection($educations),
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEducationRequest $request)
    {
        $education =Education::create($request->validated());

         return response()->json([
        'success' => true,
        'message' => 'Education created successfully.',
        'data' => new EducationResource($education),
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        return response()->json([
        'success' => true,
        'data' => new EducationResource($education),
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationRequest $request, Education $education)
    {
          $education->update($request->validated());

     return response()->json([
        'success' => true,
        'message' => 'Education updated successfully.',
        'data' => new EducationResource($education),
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        $education->delete();

        return response()->json([
            'success' => true,
            'message' => 'Education deleted successfully.'
        ]);
    }
}
