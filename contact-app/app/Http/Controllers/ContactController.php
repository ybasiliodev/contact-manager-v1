<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\ContactService;

class ContactController extends Controller
{
    public function __construct(Contact $contact, ContactService $contactService)
    {
        $this->contact = $contact;
        $this->contactService = $contactService;
    }

    public function index()
    {
        $contact = $this->contact->all();
        return response()->json(['status' => true,'data' => $contact], 200);
    }

    public function show($id)
    {
        $contact = $this->contact->findOrFail($id);
        return response()->json(['status' => true,'data' => $contact], 200);
    }

    public function showByUser(Request $request)
    {
        $contact = $this->contactService->filterContactResults($request, $this->contact);
        return response()->json(['status' => true,'data' => $contact], 200);
    }

    public function update(Request $request, $id)
    {
        $contact = $this->contact->find($id);
        if($contact === null) {
            return response()->json(['erro' => 'Contato não encontrado'], 404);
        }
        $request->validate($this->contact->rules(), $this->contact->feedback());
        $contact->update($request->all());
        return response()->json(['status' => true,'data' => $contact], 201);
    }

    public function destroy(Request $request)
    {
        $contact = $this->contact->find($id);
        if($contact === null) {
            return response()->json(['erro' => 'Contato não encontrado'], 404);
        }
        $contact->delete();
        return response()->json(['status' => true,'data' => $contact], 201);
    }
}
