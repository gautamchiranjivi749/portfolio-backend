<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $query = Service::orderBy('sort_order');

    // Only show active services on public routes
    if (request()->routeIs('public.*')) {
        $query->where('status', true);
    }

    return response()->json([
        'success' => true,
        'data' =>ServiceResource::collection($query->get()),
    ]);
}

    /**
     * Store a new service.
     */
    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Service created successfully.',
            'data' => new ServiceResource($service)        ], 201);
    }

    /**
     * Display a single service.
     */
    public function show(Service $service)
    {
        return response()->json([
            'success' => true,
            'message' => 'Service retrieved successfully.',
            'data' => new ServiceResource($service),
        ]);
    }

    /**
     * Update a service.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully.',
            'data' => new ServiceResource($service),
        ]);
    }

    /**
     * Delete a service.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.',
        ]);
    }
}