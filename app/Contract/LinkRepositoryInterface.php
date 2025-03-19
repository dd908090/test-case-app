<?php

namespace App\Contract;

use app\Models\Link;

interface LinkRepositoryInterface
{
    public function getAllLinks();
    public function getLinkById(Link $Link);
    public function deleteLink(Link $Link);
    public function saveLink(array $attributes);
    public function updateLink(Link $Link, array $attributes);
}
