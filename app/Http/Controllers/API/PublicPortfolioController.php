<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SkillResource;
use App\Http\Resources\SocialLinkResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class PublicPortfolioController extends Controller
{
    /**
     * Display a user's public portfolio.
     */
  public function index(string $username): JsonResponse
{
    $username = trim($username);

    $user = User::with([
        'abouts',
        'skills',
        'educations',
        'services',
        'certificates',
        'socialLinks',
    ])->where('username', $username)
      ->firstOrFail();

    return response()->json([
        'success' => true,
        'message' => 'Portfolio fetched successfully.',
        'data' => [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
            ],

            'about' => $user->abouts->isNotEmpty()
                ? new AboutResource($user->abouts->first())
                : null,

            'skills' => SkillResource::collection($user->skills),
            'educations' => EducationResource::collection($user->educations),
            'services' => ServiceResource::collection($user->services),
            'certificates' => CertificateResource::collection($user->certificates),
            'social_links' => SocialLinkResource::collection($user->socialLinks),
        ],
    ]);
}

}