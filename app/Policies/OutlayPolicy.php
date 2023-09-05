<?php

namespace App\Policies;

use App\Models\Outlay;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OutlayPolicy
{
    public function update(User $user, Outlay $outlay): Response
    {
        return $outlay->user->is($user) ? Response::allow()
            : Response::deny('Usuário não possuí permissão para alterar essa despesa.');
    }

    public function delete(User $user, Outlay $outlay): Response
    {
        return $outlay->user->is($user) ? Response::allow()
        : Response::deny('Usuário não possuí permissão para apagar essa despesa.');
    }
}
