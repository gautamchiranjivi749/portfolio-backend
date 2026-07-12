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
public function index(Request $request)
{
    // Step 1: Create query builder
    $query = Education::query();

    // Step 2: Apply search (if provided)
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('institution_name', 'like', '%' . $request->search . '%')
              ->orWhere('degree', 'like', '%' . $request->search . '%')
              ->orWhere('field_of_study', 'like', '%' . $request->search . '%');

        });
    }
      if($request->has('status')){
        $query->where('status', $request->status);
    }
      // Allowed sort columns
    $allowedSorts = [
        'institution_name',
        'degree',
        'start_year',
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

     // Pagination
    $perPage = $request->integer('per_page', 10);

    $educations = $query->paginate($perPage);


    // Step 4: Return response
   return $this->paginatedResponse(
    EducationResource::collection($educations),
    $educations
);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEducationRequest $request)
    {
        $education =Education::create($request->validated());

        return $this->successResponse(
        new EducationResource($education),
        'Education created successfully.',
        201
);
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
       return $this->successResponse(
    new EducationResource($education)
);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationRequest $request, Education $education)
    {
         $education->update($request->validated());

     return $this->successResponse(
    new EducationResource($education),
    'Education updated successfully.'
);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
     $education->delete();
    return $this->successResponse(
    null,
    'Education deleted successfully.'
);
    }
}
