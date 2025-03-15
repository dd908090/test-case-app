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

    public function shortUrlInDB($short_url)
    {
        return Link::where('short_url', $short_url)->exists();
    }

    public function findOriginalUrl($short_url)
    {
        return Link::query()->where('short_url', $short_url)->first();
    }

}
