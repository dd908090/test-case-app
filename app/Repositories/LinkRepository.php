<?php

namespace App\Repositories;

use App\Contract\LinkRepositoryInterface;
use App\Models\Link;

class LinkRepository implements LinkRepositoryInterface
{
    public function findExpired($date)
    {
        return Link::where('expired_at', '<', $date)->get();
    }

    public function getAllLinksByUser($user_id)
    {
        return Link::where('user_id', $user_id)->get();
    }

    public function getAllLinks()
    {
        return Link::all();
    }

    public function getLinkById($linkId)
    {
        return Link::where('id', $linkId)->first();
    }

    public function deleteLink(Link $link)
    {
        $link->delete();
    }

    public function saveLink(array $attributes)
    {

        return Link::create($attributes);
    }

    public function updateLink(Link $link, array $attributes)
    {
        return $link->update($attributes);
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
