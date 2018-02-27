<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $formattedUser = [
            'id'                    => $user->id,
            'email'                 => $user->email,
            'createdAt'             => (string) $user->created_at,
            'updatedAt'             => (string) $user->updated_at
        ];

        return $formattedUser;
    }
}