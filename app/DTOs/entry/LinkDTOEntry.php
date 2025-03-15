<?php

namespace App\DTOs\entry;

use App\Http\Requests\Link\StoreRequest;
use DateTime;

class LinkDTOEntry
{
    public function __construct(
        public readonly string $original_url,
        public readonly string $expired_at = null,
        public readonly string $custom_url = null,
        public readonly string $length = null,
    ) {
    }

    public static function forStoreRequest(StoreRequest $request)
    {
        $validated = $request->validate();
        return new self(
            original_url: $validated['original_url'],
            custom_url: $validated['custom_url'],
            expired_at: $validated['expired_at'],
        );
    }
    public static function forRedirect(string $short_url)
    {
        return new self($short_url);
    }
}
