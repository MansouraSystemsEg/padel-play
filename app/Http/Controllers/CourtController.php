<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courts\CourtCreateRequest;
use App\Http\Requests\Courts\CourtUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Court;
use App\Models\Region;
use App\Models\User;

class CourtController extends Controller
{
    public function index(): Response
    {
        $per_page = request()->input('per_page', default: 30);
        $courts = Court::with('region.parent')->paginate($per_page);

        return Inertia::render('courts/index', [
            'courts' => $courts->items(),
            'currentPage' => $courts->currentPage(),
            'nextPageUrl' => $courts->nextPageUrl(),
            'prevPageUrl' => $courts->previousPageUrl(),
        ]);
    }

    public function create(int|null $id): Response
    {
        $regions = Region::all();
        $users = User::all();

        return Inertia::render('courts/show', [
            'regions' => $regions,
            'regionID' => $id,
            'users' => $users,
        ]);
    }

    public function store(CourtCreateRequest $request): RedirectResponse
    {
        $court = new Court();
        $court->fill($request->validated());
        $court->save();

        return to_route('courts.index');
    }

    public function edit(int $id): Response
    {
        $regions = Region::all();
        $court = Court::findOrFail($id);
        $users = User::all();

        return Inertia::render('courts/show', [
            'court' => $court,
            'regions' => $regions,
            'users' => $users,
        ]);
    }

    public function update(CourtUpdateRequest $request): RedirectResponse
    {
        $court = Court::findOrFail($request->id);
        $court->fill($request->validated());
        $court->save();

        return to_route('courts.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $court = Court::findOrFail($id);
        $court->delete();

        return to_route('courts.index');
    }
}
