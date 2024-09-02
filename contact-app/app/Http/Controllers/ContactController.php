<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\ContactService;
use App\Services\UserService;

class ContactController extends Controller
{
    public function __construct(Contact $contact, ContactService $contactService)
    {
        $this->contact = $contact;
        $this->contactService = $contactService;
    }

    public function show($id)
    {
        $contact = $this->contact->findOrFail($id);
        return response()->json(['status' => true,'data' => $contact], 200);
    }

    public function store(Request $request)
    {
        $data = $this->contactService->createContact($request);
        return response()->json($data['message'], $data['status']);
    }

    public function update(Request $request, $id)
    {
        $data = $this->contactService->updateContact($request, $id);
        return response()->json($data['message'], $data['status']);
    }

    public function destroy($id)
    {
        $data = $this->contactService->deleteContact($id);
        return response()->json($data['message'], $data['status']);
    }

    public function showByUser(Request $request)
    {
        $contact = $this->contactService->filterContactResults($request, $this->contact);
        return response()->json($contact, 200);
    }
}
