<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSocialLinkRequest;
use App\Http\Requests\UpdateSocialLinkRequest;
use App\Models\SocialLink;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json([
            'success' => true,
            'data' => SocialLink::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(StoreSocialLinkRequest $request)
    {
        $social = SocialLink::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Social link created successfully.',
            'data' => $social
        ], 201);
    }

    /**
     * Display the specified resource.
     */
     public function show(SocialLink $socialLink)
    {
        return response()->json([
            'success' => true,
            'data' => $socialLink
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdateSocialLinkRequest $request, SocialLink $socialLink)
    {
        $socialLink->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Social link updated successfully.',
            'data' => $socialLink
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
       public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return response()->json([
            'success' => true,
            'message' => 'Social link deleted successfully.'
        ]);
    }
}
