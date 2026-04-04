<?php

namespace App\Http\Controllers;

use App\Enums\ContactStatus;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = $request->user()->contacts()->create($request->validated());

        return response()->json($contact, 201);
    }

    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        Gate::authorize('update', $contact);

        $contact->update($request->validated());

        return response()->json($contact);
    }

    public function archive(Contact $contact): JsonResponse
    {
        Gate::authorize('archive', $contact);

        $contact->update(['status' => ContactStatus::Archived]);

        return response()->json(['message' => 'Contact archived.']);
    }

    public function restore(Contact $contact): JsonResponse
    {
        Gate::authorize('restore', $contact);

        $contact->update(['status' => ContactStatus::Active]);

        return response()->json(['message' => 'Contact restored.']);
    }

    public function destroy(Contact $contact): JsonResponse
    {
        Gate::authorize('delete', $contact);

        $contact->delete();

        return response()->json(['message' => 'Contact deleted.']);
    }
}
