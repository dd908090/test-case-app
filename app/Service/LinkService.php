<?php

namespace App\Service;

use App\Exceptions\LinkAlreadyTakenException;
use App\Exceptions\LinkExpiredException;
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
                throw new LinkAlreadyTakenException('The link is already taken');
            } else {
                $link_data['short_url'] = $link_data['custom_url'];
            }
        }

        $this->linkRepository->update($link, $link_data);
    }

    public function getAllLinks(int $user_id)
    {
        return $this->linkRepository->getAllByUser($user_id);
    }

    public function getLink($linkId)
    {
        return $this->linkRepository->getById($linkId);
    }

    public function createLink($linkDTO)
    {
        $user_id = Auth::user()->id;
        $original_url = $linkDTO->getOriginalUrl();
        $expired_at = $linkDTO->getExpiredAt() ?? $this->expiredAtDefault();

        if (!empty($linkDTO->getCustomUrl())) {
            if ($this->linkRepository->shortUrlInDB($linkDTO->getCustomUrl())) {
                throw new LinkAlreadyTakenException();
            }
            $short_url = $linkDTO->getCustomUrl();
        } else {
            $short_url = $this->generateUniqueShortUrl();
        }

        $link = $this->linkRepository->save([
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

        if (empty($link)) {
            throw new LinkExpiredException();
        }

        return $link;
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
