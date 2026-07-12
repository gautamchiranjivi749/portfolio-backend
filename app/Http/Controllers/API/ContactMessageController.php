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
    public function index(Request $request)
{
    // Create query builder
    $query = Contact::query();

    // Search
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('subject', 'like', '%' . $request->search . '%')
              ->orWhere('message', 'like', '%' . $request->search . '%');

        });

    }

    // Filter (Uncomment if you have an is_read column)
    /*
    if ($request->has('is_read')) {

        $query->where('is_read', $request->is_read);

    }
    */

    // Allowed sort columns
    $allowedSorts = [
        'name',
        'email',
        'created_at',
    ];

    // Get sort column (default: newest first)
    $sort = $request->get('sort', 'created_at');

    // Default direction
    $direction = 'desc';

    // Descending sort with "-" prefix
    if (str_starts_with($sort, '-')) {

        $direction = 'desc';
        $sort = substr($sort, 1);

    } else {

        $direction = 'asc';

        // Keep created_at descending by default
        if ($sort === 'created_at') {
            $direction = 'desc';
        }

    }

    // Validate sort column
    if (! in_array($sort, $allowedSorts)) {

        $sort = 'created_at';
        $direction = 'desc';

    }

    // Apply sorting
    $query->orderBy($sort, $direction);

    // Pagination
    $perPage = $request->integer('per_page', 10);

    $contacts = $query->paginate($perPage);

    // Return response
  return $this->paginatedResponse(
    ContactResource::collection($contacts),
    $contacts
);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactMessageRequest $request)
{
    $message = Contact::create($request->validated());

    return $this->successResponse(
        new ContactResource($message),
        'Your message has been sent successfully.',
        201
    );
}

    /**
     * Display the specified resource.
     */
     public function show(Contact $contact)
    {
       return $this->successResponse(
    new ContactResource($contact)
);
    }

    /**
     * Update the specified resource in storage.
     */
       public function update(UpdateContactMessageRequest $request, Contact $contact)
    {
        $contact->update($request->validated());

        return $this->successResponse(
            new ContactResource($contact),
            'Contact updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Contact $contact)
    {
        $contact->delete();

        return $this->successResponse(
            null,
            'Contact deleted successfully.'
        );
    }
}
