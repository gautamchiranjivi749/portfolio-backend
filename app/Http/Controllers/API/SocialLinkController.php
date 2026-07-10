<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSocialLinkRequest;
use App\Http\Requests\UpdateSocialLinkRequest;
use App\Models\SocialLink;
use App\Http\Resources\SocialLinkResource;
use Illuminate\Support\Facades\Storage;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
    $socialLinks = SocialLink::orderBy('sort_order')->get();

    return response()->json([
        'success' => true,
        'data' => SocialLinkResource::collection($socialLinks),
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(StoreSocialLinkRequest $request)
    {
        $data = $request->validated();

    if ($request->hasFile('icon')) {
        $data['icon'] = $request->file('icon')->store('social-links', 'public');
    }

    $socialLink = SocialLink::create($data);

    return response()->json([
        'success' => true,
        'message' => 'Social link created successfully.',
        'data' => new SocialLinkResource($socialLink),
    ], 201);
    }

    /**
     * Display the specified resource.
     */
     public function show(SocialLink $socialLink)
    {
          return response()->json([
        'success' => true,
        'data' => new SocialLinkResource($socialLink),
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdateSocialLinkRequest $request, SocialLink $socialLink)
    {
        $data = $request->validated();

    if ($request->hasFile('icon')) {

        if ($socialLink->icon) {
            Storage::disk('public')->delete($socialLink->icon);
        }

        $data['icon'] = $request->file('icon')->store('social-links', 'public');
    }

    $socialLink->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Social link updated successfully.',
        'data' => new SocialLinkResource($socialLink),
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
       public function destroy(SocialLink $socialLink)
    {
        if ($socialLink->icon) {
        Storage::disk('public')->delete($socialLink->icon);
    }

    $socialLink->delete();

    return response()->json([
        'success' => true,
        'message' => 'Social link deleted successfully.',
    ]);
    }
}
