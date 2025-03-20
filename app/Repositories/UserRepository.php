<?php

namespace App\Repositories;

use App\Contract\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAll()
    {
        return User::all();
    }

    public function getById(User $User)
    {
        return $User;
    }

    public function delete(User $User)
    {
        $User->delete();
    }

    public function create(array $attributes)
    {
        return User::create($attributes);
    }

    public function update(User $User, array $attributes)
    {
        return $User->update($attributes);
    }
}
