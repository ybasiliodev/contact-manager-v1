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
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function filterContactResults(Request $request, Contact $contact) {
        
        $perPage = $request->input('perPage', '10');
        $sorts = explode(',', $request->input('sort', 'name'));
        $contact = $contact->where('user_id', '=', $this->userService->getLoggedUserId());
        
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
}
