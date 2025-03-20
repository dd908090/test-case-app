<?php

namespace App\DTOs\Entry;

use DateTime;

readonly  class LinkDTOStore
{

    public function __construct(
        public int $user_id,
        public string $original_url,
        public string $custom_url,
        public string $expired_at,
    )
    {}

    public function getOriginalUrl(): string
    {
        return $this->original_url;
    }

    public function getCustomUrl(): ?string
    {
        return $this->custom_url;
    }

    public function getExpiredAt(): ?string
    {
        return $this->expired_at;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'original_url' => $this->original_url,
            'custom_url' => $this->custom_url,
            'expired_at' => $this->expired_at,
        ];
    }
}
