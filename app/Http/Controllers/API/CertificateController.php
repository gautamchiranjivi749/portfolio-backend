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
    public function index()
    {
         $certificates = Certificate::orderBy('sort_order')->get();

    
    return response()->json([
        'success' => true,
        'data' => CertificateResource::collection($certificates),
    ]);
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

    return response()->json([
        'success' => true,
        'message' => 'Certificate created successfully.',
        'data' => new CertificateResource($certificate),
    ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        return response()->json([
        'success' => true,
        'data' => new CertificateResource($certificate),
    ]);
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

   return response()->json([
        'success' => true,
        'message' => 'Certificate updated successfully.',
        'data' => new CertificateResource($certificate),
    ]);
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

    return response()->json([
        'success' => true,
        'message' => 'Certificate deleted successfully.'
    ]);
}
}
