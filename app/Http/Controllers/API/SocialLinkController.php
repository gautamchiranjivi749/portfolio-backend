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
    public function index(Request $request)
    { 
    $query = SocialLink::query();

    if ($request->filled('search')) {

    $query->where('platform', 'like', '%' . $request->search . '%');

}
  if($request->has('status')){
        $query->where('status', $request->status);
    }

       // Allowed sort columns
    $allowedSorts = [
        'platform',
        'sort_order',
        'created_at',
    ];

    // Read sort parameter
    $sort = $request->get('sort', 'sort_order');

    // Default direction
    $direction = 'asc';

    // Check for descending sort
    if (str_starts_with($sort, '-')) {

        $direction = 'desc';

        $sort = substr($sort, 1);

    }

    // Validate sort column
    if (! in_array($sort, $allowedSorts)) {

        $sort = 'sort_order';

    }

    // Apply sorting
    $query->orderBy($sort, $direction);

    // Step 3: Sort and fetch data
    // Pagination
    $perPage = $request->integer('per_page', 10);

    $socialLinks = $query->paginate($perPage);

       
   return $this->paginatedResponse(
    SocialLinkResource::collection($socialLinks),
    $socialLinks
);
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

    return $this->successResponse(
        new SocialLinkResource($socialLink),
        'Social link created successfully.',
        201
    );
    }

    /**
     * Display the specified resource.
     */
     public function show(SocialLink $socialLink)
    {
          return $this->successResponse(
    new SocialLinkResource($socialLink)
);
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

   return $this->successResponse(
        new SocialLinkResource($socialLink),
        'Social link updated successfully.'
    );
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

    return $this->successResponse(
        null,
        'Social link deleted successfully.'
    );
    }
}
