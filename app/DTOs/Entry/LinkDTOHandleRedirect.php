<?php

namespace App\DTOs\Entry;

readonly class LinkDTOHandleRedirect
{
    public function __construct(
        public string $short_url
    ) {}
    public function getShortUrl(): string
    {
        return $this->short_url;
    }
}
