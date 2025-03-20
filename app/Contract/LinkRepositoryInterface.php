<?php

namespace App\Contract;

use app\Models\Link;

interface LinkRepositoryInterface
{
    public function getAll();
    public function getById(Link $Link);
    public function delete(Link $Link);
    public function save(array $attributes);
    public function update(Link $Link, array $attributes);
}
