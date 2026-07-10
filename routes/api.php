<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AboutController;
use App\Http\Controllers\API\SkillController;
use App\Http\Controllers\API\EducationController;
use App\Http\Controllers\API\CertificateController;
use App\Http\Controllers\API\SocialLinkController;
use App\Http\Controllers\API\ContactMessageController;
use App\Http\Controllers\API\AuthController;



//for public
//http://127.0.0.1:8000/api/public/
Route::prefix('public')->group(function () {

    Route::get('/about', [AboutController::class, 'index']);

    Route::get('/skills', [SkillController::class, 'index']);

    Route::get('/educations', [EducationController::class, 'index']);

    Route::get('/social-links', [SocialLinkController::class, 'index']);

    Route::get('/certificates', [CertificateController::class, 'index']);

    Route::post('/contact', [ContactMessageController::class, 'store']);

});

//for authenticated users

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::apiResource('about', AboutController::class);

    Route::apiResource('skills', SkillController::class);

    Route::apiResource('educations', EducationController::class);

    Route::apiResource('certificates', CertificateController::class);

    // Route::apiResource('projects', ProjectController::class);

    // Route::apiResource('services', ServiceController::class);

    // Route::apiResource('experiences', ExperienceController::class);

    Route::apiResource('social-links', SocialLinkController::class);

    Route::apiResource('contacts', ContactMessageController::class)->except(['store']);

});

    //for admin login
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1'); // limits to 5 attempts per minute
});




