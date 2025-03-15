<?php

namespace App\DTOs\refund;

class LinkDTORefund
{
    public function __construct(
        public readonly ?string $short_url = null,
        public readonly ?string $original_url = null,
        public readonly ?string $message = null,
    ) {
    }

    public static function fromService(string $short_url, string $message)
    {
        return new self(short_url: $short_url, message: $message);
    }

    public static function fromRedirect(string $original_url)
    {
        return new self(original_url: $original_url);
    }
}
