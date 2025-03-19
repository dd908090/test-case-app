<?php

namespace App\Service;

use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Support\Facades\Auth;

class LinkService
{

    protected LinkRepository $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }


    public function updateLink(Link $link, $linkDTO)
    {

        $link_data = $linkDTO->toArray();
        if (!empty($link_data["custom_url"])) {
            if ($this->linkRepository->shortUrlInDB($linkDTO->getCustomUrl())) {
                return abort(409, 'The link is already taken');
            } else {
                $link_data['short_url'] = $link_data['custom_url'];
            }
        }


        $this->linkRepository->updateLink($link, $link_data);
    }

    public function getAllLinks()
    {
        return $this->linkRepository->getAllLinksByUser(Auth::user()->id);
    }

    public function getLink($linkId)
    {
        return $this->linkRepository->getLinkById($linkId);
    }

    public function createLink($linkDTO)
    {
        $user_id = Auth::user() -> id;
        $original_url = $linkDTO->getOriginalUrl();
        $expired_at = $linkDTO->getExpiredAt() ?? $this->expiredAtDefault();

        if (!empty($linkDTO->getCustomUrl())) {
            if ($this->linkRepository->shortUrlInDB($linkDTO->getCustomUrl())) {
                return abort(409, 'The link is already taken');
            }
            $short_url = $linkDTO->getCustomUrl();
        } else {
            $short_url = $this->generateUniqueShortUrl();
        }

        $link = $this->linkRepository->saveLink([
            'original_url' => $original_url,
            'short_url' => $short_url,
            'user_id' => $user_id,
            'expired_at' => $expired_at,
        ]);

        return $link;
    }

    public function handleRedirect($linkDTO)
    {

        $link = $this->linkRepository->findOriginalUrl($linkDTO->getShortUrl());
        if (empty($link)) return abort(409, 'Link expired'); else return $link;

    }



    public function generateUniqueShortUrl($length = 6)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_~.';
        do {
            $short_url = $this->generateRandomString($length, $characters);
        } while ($this->linkRepository->shortUrlInDB($short_url));
        return $short_url;
    }

    public function generateRandomString($length, $characters)
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function expiredAtDefault()
    {
        return now()->addYear();
    }

}
