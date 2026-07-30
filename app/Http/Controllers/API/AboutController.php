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
    $about = About::where('user_id', auth()->id())->first();

    return response()->json([
        'success' => true,
        'data' => $about ? new AboutResource($about) : null,
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreAboutRequest $request)
{
    $data = $request->validated();

    $data['user_id'] = auth()->id();

    // Upload profile image
    if ($request->hasFile('profile_image')) {
        $data['profile_image'] = $request->file('profile_image')
            ->store('abouts/profile-images', 'public');
    }

    // Upload resume
    if ($request->hasFile('resume')) {
        $data['resume'] = $request->file('resume')
            ->store('abouts/resumes', 'public');
    }

    $about = About::updateOrCreate(
        ['user_id' => auth()->id()],
        $data
    );

    return response()->json([
        'success' => true,
        'message' => 'About saved successfully.',
        'data' => new AboutResource($about),
    ], 200);
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
