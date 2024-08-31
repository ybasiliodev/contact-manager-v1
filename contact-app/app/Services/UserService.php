<?php

namespace App\Services;

use App\Models\Contact;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
