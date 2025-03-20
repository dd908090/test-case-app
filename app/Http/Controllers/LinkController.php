<?php

namespace App\Http\Controllers;

use App\DTOs\Entry\LinkDTOHandleRedirect;
use App\DTOs\Entry\LinkDTOStore;
use App\DTOs\Entry\LinkDTOUpdate;
use App\Exceptions\LinkAlreadyTakenException;
use App\Exceptions\LinkExpiredException;
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

    public function index(): Response
    {
        $user_id = Auth::user()->id;

        $links = $this->linkService->getAllLinks($user_id);
        return Inertia::render("Links/IndexPage", [
            'links' => $links
        ]);
    }

    public function create(): Response
    {
        return Inertia::render("Links/CreatePage");
    }

    public function store(Request $request)
    {
        $data_validated = $request->validate([
            'original_url' => 'required|url',
            'custom_url' => 'nullable|string|max:255',
            'expired_at' => 'nullable|date',
        ]);

        $linkDTO = new LinkDTOStore(
            Auth::user()->id,
            $data_validated['original_url'],
            $data_validated['custom_url'] ?? null,
            $data_validated['expired_at'] ?? null
        );

        try {
            $link = $this->linkService->createLink($linkDTO);
            return to_route('links.index');
        } catch (LinkAlreadyTakenException $e) {
            abort(409, $e->getMessage());
        }
    }



    public function show($linkId): Response
    {
        $link = $this->linkService->getLink($linkId);

        return Inertia::render("Links/ShowPage", [
            'link' => $link
        ]);
    }

    public function edit(Link $link): Response
    {
        return Inertia::render("Links/EditPage", [
            "link" => $link
        ]);
    }

    public function update(Request $request, Link $link): \Illuminate\Http\RedirectResponse
    {
        $data_validated = $request->validate([
            'original_url' => 'required|url',
            'custom_url' => 'nullable|string|max:255',
            'expired_at' => 'nullable|date',
        ]);

        $linkDTO = new LinkDTOUpdate(
            Auth::user()->id,
            $data_validated['original_url'],
            $data_validated['custom_url'] ?? null,
            $data_validated['expired_at'] ?? null
        );

        try {
            $this->linkService->updateLink($link, $linkDTO);
            return to_route('links.show', ['link' => $link->id]);
        } catch (LinkAlreadyTakenException $e) {
            abort(409, $e->getMessage());
        }
    }

    public function destroy(Link $link): \Illuminate\Http\RedirectResponse
    {
        $link->delete();
        return Redirect::route("links.index");
    }
    public function handleRedirect($shortUrl)
    {
        try {
            $linkDTO = new LinkDTOHandleRedirect($shortUrl);
            $link = $this->linkService->handleRedirect($linkDTO);
            return redirect($link->original_url);
        } catch (LinkExpiredException $e) {
            abort(409, $e->getMessage());
        }
    }
}
