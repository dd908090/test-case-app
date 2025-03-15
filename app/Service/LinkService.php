<?php

namespace App\Service;

use App\DTOs\refund\LinkDTORefund;
use App\Repositories\LinkRepository;
use Auth;
class LinkService
{

    protected $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }


    public function createLinkService($linkDto)
    {

        $original_url = $linkDto->original_url;
        $expired_at = $linkDto->expired_at ?? $this->expiredAtDefault();

        if (!empty($linkDto['custom_url'])) {
            if ($this->linkRepository->shortUrlInDB($linkDto['custom_url'])) {
                return $message = 'The link is already taken';
            }
            $short_url = $linkDto['custom_url'];
        } else {
            $short_url = $this->generateUniqueShortUrl($linkDto['length']);
        }

        $this->linkRepository->createLink([
            'original_url' => $original_url,
            'short_url' => $short_url,
            'user_id' => Auth::id(),
            'expired_at' => $expired_at,
        ]);
        $message = 'The short url has been successfully created';
        return new LinkDTORefund::fromService($message,$short_url);



    }

    public function handleRedirectService($linkDto)
    {
        $original_url = $this->linkRepository->findOriginalUrl($linkDto->short_url);

        $message = 'Redirected to original URL';
        return new LinkDTORefund::fromRedirect($original_url, $message);

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
