<?php

namespace App\Repositories;

use App\Contract\LinkRepositoryInterface;
use App\Models\Link;

class LinkRepository implements LinkRepositoryInterface
{
    public function getAllLinks()
    {
        return Link::all();
    }

    public function getLinkById(Link $Link)
    {
        return $Link;
    }

    public function deleteLink(Link $Link)
    {
        $Link->delete();
    }

    public function createLink(array $attributes)
    {
        return Link::create($attributes);
    }

    public function updateLink(Link $Link, array $attributes)
    {
        return $Link->update($attributes);
    }
}
