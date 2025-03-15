<?php

namespace App\Http\Controllers;

use App\DTOs\entry\LinkDTOEntry;
use App\DTOs\refund\LinkDTORefund;
use App\Http\Requests\Link\StoreRequest;
use App\Service\LinkService;
use Inertia\Inertia;

class LinkController extends Controller
{
    private LinkService $linkService;
    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $linkDto = LinkDTOEntry::forStoreRequest($request);
        $this->linkService->createLinkService($linkDto);
        // создать дто из реквеста и им передать в сервис
        //обращаться к linkservice


        // поулчаем data с return dto
        $data = LinkDTORefund::fromService();

        return inertia("Link/Show", [
            'short_url' => $data->short_url,
            'message' => $data->message,
        ]);
    }

    public function handleRedirect($short_url)
    {
        $linkDto = LinkDTOEntry::forRedirect($short_url);
        $this->linkService->handleRedirectService($linkDto);


        $data = LinkDTORefund::fromRedirect();
        return $data->original_url ? redirect($data->original_url) : abort(404, message: "Link not found.");

    }

}
