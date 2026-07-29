<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAboutRequest;
use App\Http\Requests\UpdateAboutRequest;
use App\Models\About;
use App\Http\Resources\AboutResource;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $abouts = About::where('user_id', auth()->id())
                    ->latest()
                    ->get();

    return response()->json([
        'success' => true,
        'data' => AboutResource::collection($abouts),
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreAboutRequest $request)
{
    $data = $request->validated();

    $data['user_id'] = auth()->id();

    $about = About::create($data);

    return response()->json([
        'success' => true,
        'message' => 'About created successfully.',
        'data' => new AboutResource($about),
    ], 201);
}

    /**
     * Display the specified resource.
     */
  public function show($id)
{
    $about = About::where('user_id', auth()->id())
                  ->findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => new AboutResource($about),
    ]);
}

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateAboutRequest $request, $id)
{
    $about = About::where('user_id', auth()->id())
                  ->findOrFail($id);

    $about->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'About updated successfully.',
        'data' => new AboutResource($about),
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    $about = About::where('user_id', auth()->id())
                  ->findOrFail($id);

    $about->delete();

    return response()->json([
        'success' => true,
        'message' => 'About deleted successfully.',
    ]);
}
}
