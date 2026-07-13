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
        $about = About::latest()->first();
        return response()->json([
            'success' => true,
            'data'=> new AboutResource($about),
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAboutRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
        $data['profile_image'] = $request->file('profile_image')
            ->store('abouts', 'public');
    }

    if ($request->hasFile('resume')) {
        $data['resume'] = $request->file('resume')
            ->store('resumes', 'public');
    }

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
    public function show(About  $about)
    {
         return response()->json([
        'success' => true,
        'data' => new AboutResource($about),
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutRequest $request, About $about)
    {
         $data = $request->validated();

    if ($request->hasFile('profile_image')) {

        if ($about->profile_image) {
            Storage::disk('public')->delete($about->profile_image);
        }

        $data['profile_image'] = $request->file('profile_image')
            ->store('abouts', 'public');
    }

    if ($request->hasFile('resume')) {

        if ($about->resume) {
            Storage::disk('public')->delete($about->resume);
        }

        $data['resume'] = $request->file('resume')
            ->store('resumes', 'public');
    }

    $about->update($data);

   return response()->json([
    'success' => true,
    'message' => 'About updated successfully.',
    'data' => new AboutResource($about),
]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
         if ($about->profile_image) {
        Storage::disk('public')->delete($about->profile_image);
    }

    if ($about->resume) {
        Storage::disk('public')->delete($about->resume);
    }

    $about->delete();

    return response()->json([
        'success' => true,
        'message' => 'About deleted successfully.',
    ]);
    }
}
