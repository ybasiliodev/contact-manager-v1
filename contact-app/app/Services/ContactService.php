<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Str;

class ContactService
{
    /**
     * Create a new class instance.
     */
    public function __construct(Contact $contact, UserService $userService)
    {
        $this->contact = $contact;
        $this->userService = $userService;
    }

    public function createContact(Request $request) {
        $request->request->add(['user_id' => $this->userService->getLoggedUserId()]);
        $request->validate($this->contact->rules(), $this->contact->feedback());
        $this->contact->create($request->all());

        return ["message" => "Contato Incluido com sucesso", "status" => 201];
    }

    public function updateContact(Request $request, $id) {
        $request->request->add(['user_id' => $this->userService->getLoggedUserId()]);
        $contact = $this->getContact($id);
        
        if($contact === null) {
            return ["message" => "Contato não encontrado!", "status" => 404];
        }

        $request->validate($this->contact->updateRules($id), $this->contact->feedback());
        $contact->update($request->all());

        return ["message" => "Contato atualizado com sucesso", "status" => 200];
    }

    public function deleteContact($id) {
        $contact = $this->getContact($id);
        
        if($contact === null) {
            return ["message" => "Contato não encontrado!", "status" => 404];
        }

        $contact->delete();

        return ["message" => "Contato excluido com sucesso", "status" => 204];
    }

    public function filterContactResults(Request $request) {
        
        $perPage = $request->input('perPage', '10');
        $sorts = explode(',', $request->input('sort', 'name'));
        $contact = $this->contact->where('user_id', $this->userService->getLoggedUserId());
        
        if ($request->has('name')) {
            $contact = $contact->where('name', 'like', "%{$request->input('name')}%");
        }

        if ($request->has('cpf')) {
            $contact = $contact->where('social_number', 'like', "%{$request->input('cpf')}%");
        }

        foreach ($sorts as $sortColumn) {
            $sortDirection = Str::startsWith($sortColumn, '-') ? 'desc' : 'asc';
            $sortColumn = ltrim($sortColumn, '-');
            if (in_array($sortColumn,['name','social_number'])){
                $contact->orderBy($sortColumn, $sortDirection);
                continue;
            }
        }

        return $contact->paginate($perPage);
    }

    private function getContact($id) {
        return $this->contact->where('user_id', $this->userService->getLoggedUserId())->where('id', $id);
    }
}
