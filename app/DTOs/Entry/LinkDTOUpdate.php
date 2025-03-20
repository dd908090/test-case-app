<?php

namespace App\DTOs\Entry;

class LinkDTOUpdate
{
    private string $original_url;
    private ?string $custom_url;
    private ?string $expired_at;
    private int $user_id;

    public function __construct(
        int $user_id,
        $original_url,
        $custom_url,
        $expired_at,
    ) {
        $this->original_url = $original_url;
        $this->custom_url = $custom_url;
        $this->expired_at = $expired_at;
        $this->user_id = $user_id;
    }

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
