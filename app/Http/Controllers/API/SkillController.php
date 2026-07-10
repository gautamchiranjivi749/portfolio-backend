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
       
       if ($request->filled('search')) {

    $query->where('name', 'like', '%' . $request->search . '%');

    }
    $skills = $query->orderBy('sort_order')->get();

    return response()->json([
        'success' => true,
        'data' =>SkillResource::collection($skills),
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {
         $skill = Skill::create($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Skill created successfully.',
        'data' => new SkillResource($skill),
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
         return response()->json([
        'success' => true,
        'data' => new SkillResource($skill),
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateSkillRequest $request, Skill $skill)
{
    $skill->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Skill updated successfully.',
        'data' => new SkillResource($skill),
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully.',
        ]);
    }
}
