<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContactMessageRequest;
use App\Http\Requests\UpdateContactMessageRequest;
use App\Models\Contact;
use App\Http\Resources\ContactResource;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $contacts = Contact::latest()->get();

    return response()->json([
        'success' => true,
        'data' => ContactResource::collection($contacts),
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
     public function store(StoreContactMessageRequest $request)
    {
        $message = Contact::create($request->validated());

      return response()->json([
        'success' => true,
        'message' => 'Your message has been sent successfully.',
        'data' => new ContactResource($contact),
    ], 201);
    }

    /**
     * Display the specified resource.
     */
     public function show(Contact $contact)
    {
         return response()->json([
        'success' => true,
        'data' => new ContactResource($contact),
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
       public function update(UpdateContactMessageRequest $request, Contact $contact)
    {
        $contact->update($request->validated());

        return response()->json([
        'success' => true,
        'message' => 'Contact updated successfully.',
        'data' => new ContactResource($contact),
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully.'
        ]);
    }
}
