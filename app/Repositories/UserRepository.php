<?php

namespace App\Repositories;

use App\Contract\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById(User $User)
    {
        return $User;
    }

    public function deleteUser(User $User)
    {
        $User->delete();
    }

    public function createUser(array $attributes)
    {
        return User::create($attributes);
    }

    public function updateUser(User $User, array $attributes)
    {
        return $User->update($attributes);
    }
}
