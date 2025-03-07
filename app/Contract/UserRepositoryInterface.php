<?php

namespace App\Contract;

use app\Models\User;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserById(User $User);
    public function deleteUser(User $User);
    public function createUser(array $attributes);
    public function updateUser(User $User, array $attributes);
}
