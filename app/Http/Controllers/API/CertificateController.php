<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use App\Models\Certificate;
use App\Http\Resources\CertificateResource;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
            public function index(Request $request)
            {
                $query = Certificate::query();
                if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('organization', 'like', '%' . $request->search . '%');

            });

        }
          if($request->has('status')){
        $query->where('status', $request->status);

    }
       // Allowed sort columns
    $allowedSorts = [
        'title',
        'organization',
        'issue_date',
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
     $perPage = $request->integer('per_page', 10);

    $certificates = $query->paginate($perPage);
    
    return $this->paginatedResponse(
    CertificateResource::collection($certificates),
    $certificates
);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCertificateRequest $request)
    {
            $data = $request->validated();

    if ($request->hasFile('image')) {

        $data['image'] = $request
            ->file('image')
            ->store('certificates', 'public');
    }

    $certificate = Certificate::create($data);

   return $this->successResponse(
    new CertificateResource($certificate),
    'Certificate created successfully.',
    201
);

    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
       return $this->successResponse(
    new CertificateResource($certificate)
);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateCertificateRequest $request, Certificate $certificate)
{
    $data = $request->validated();

    if ($request->hasFile('image')) {

        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }

        $data['image'] = $request
            ->file('image')
            ->store('certificates', 'public');
    }

    $certificate->update($data);

   return $this->successResponse(
    new CertificateResource($certificate),
    'Certificate updated successfully.'
);
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Certificate $certificate)
{
    if ($certificate->image) {
        Storage::disk('public')->delete($certificate->image);
    }

    $certificate->delete();

    return $this->successResponse(
    null,
    'Certificate deleted successfully.'
);
}
}
