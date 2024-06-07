<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class NotePolicy
{
    public function edit(User $user, Note $note): bool 
    {
        return $note->user->is(Auth::user());
    }
}
