<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use App\Http\Resources\SkillResource;


class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $query = Skill::query();

    // Search
    if ($request->filled('search')) {

        $query->where('name', 'like', '%' . $request->search . '%');

    }

    // Filter
    if ($request->has('status')) {

        $query->where('status', $request->status);

    }

    // Allowed sort columns
    $allowedSorts = [
        'name',
        'percentage',
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

    // Execute query
     // Pagination
    $perPage = $request->integer('per_page', 10);

    $skills = $query->paginate($perPage);


   return $this->paginatedResponse(
    SkillResource::collection($skills),
    $skills
);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {
         $skill = Skill::create($request->validated());

    return $this->successResponse(
    new SkillResource($skill),
    'Skill created successfully.',
    201
);
}

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
       return $this->successResponse(
    new SkillResource($skill)
);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateSkillRequest $request, Skill $skill)
{
    $skill->update($request->validated());

   return $this->successResponse(
    new SkillResource($skill),
    'Skill updated successfully.'
);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
return $this->successResponse(
    null,
    'Skill deleted successfully.'
);
    }
}
