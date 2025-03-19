<?php

namespace App\Service;

use App\Repositories\LinkRepository;
use Carbon\Carbon;

class CronJobService
{

    protected LinkRepository $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    public function checkExpiredLinks(): void
    {
        $expiredLinks = $this->linkRepository->findExpired(Carbon::now());

        foreach ($expiredLinks as $link) {
            $this->linkRepository->deleteLink($link);
        }
    }

}
