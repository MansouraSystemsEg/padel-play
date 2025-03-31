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

class CourtController extends Controller
{
    public function index(): Response
    {
        $courts = Court::all();

        return Inertia::render('courts/index', [
            'courts' => $courts,
        ]);
    }

    public function create(): Response
    {
        $regions = Region::all();
        return Inertia::render('courts/show', [
            'regions' => $regions,
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

        return Inertia::render('courts/show', [
            'court' => $court,
            'regions' => $regions,
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
