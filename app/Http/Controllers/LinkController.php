<?php

namespace App\Http\Controllers;

use App\DTOs\Entry\LinkDTOHandleRedirect;
use App\DTOs\Entry\LinkDTOShow;
use App\DTOs\Entry\LinkDTOStore;
use App\DTOs\Entry\LinkDTOUpdate;
use App\Http\Requests\Link\Request;
use App\Models\Link;
use App\Service\LinkService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    private LinkService $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function index()
    {
        $links = $this->linkService->getAllLinks();
        return Inertia::render("Links/IndexPage", [
            'links' => $links
        ]);
    }

    public function create()
    {
        return Inertia::render("Links/CreatePage");
    }

    public function store(Request $request)
    {
        $data_validated = $request->validated();

        $linkDTO = new LinkDTOStore(
            Auth::user()->id,
            $data_validated['original_url'],
            $data_validated['custom_url'] ?? null,
            $data_validated['expired_at'] ?? null
        );

        $link = $this->linkService->createLink($linkDTO);

        return to_route("links.index");

    }


    public function show($linkId): Response
    {
        $link = $this->linkService->getLink($linkId);

        return Inertia::render("Links/ShowPage", [
            'link' => $link
        ]);
    }

    public function edit(Link $link)
    {
        return Inertia::render("Links/EditPage", [
            "link" => $link
        ]);
    }

    public function update(Request $request, Link $link)
    {
        $data_validated = $request->validated();

        $linkDTO = new LinkDTOUpdate(
            Auth::user()->id,
            $data_validated['original_url'],
            $data_validated['custom_url'] ?? null,
            $data_validated['expired_at'] ?? null
        );

        $this->linkService->updateLink($link, $linkDTO);

        return to_route('links.show', ['link' => $link->id]);
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return Redirect::route("links.index");
    }


    public function handleRedirect($short_url)
    {
        $linkDTO = new LinkDTOHandleRedirect($short_url);

        $link = $this->linkService->handleRedirect($linkDTO);
        return redirect($link->original_url);
    }

}
