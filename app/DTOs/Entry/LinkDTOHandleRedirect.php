<?php

namespace App\DTOs\Entry;

class LinkDTOHandleRedirect
{
    public string $short_url;

    public function __construct(
        string $short_url
    ) {
        $this->short_url = $short_url;
    }
    public function getShortUrl(): string
    {
        return $this->short_url;
    }
}
