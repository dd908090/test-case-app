<?php

namespace App\Contract;

use app\Models\User;

interface UserRepositoryInterface
{
    public function getAll();
    public function getById(User $User);
    public function delete(User $User);
    public function create(array $attributes);
    public function update(User $User, array $attributes);
}
