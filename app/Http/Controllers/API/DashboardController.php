<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Certificate;
use App\Models\SocialLink;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
{
    return response()->json([
        'success' => true,

        'data' => [

            'about' => About::count(),

            'skills' => Skill::count(),

            'educations' => Education::count(),

            'certificates' => Certificate::count(),

            'social_links' => SocialLink::count(),

            'contact_messages' => Contact::count(),

            'unread_messages' => Contact::where('is_read', false)->count(),

        ]

    ]);
}
}
