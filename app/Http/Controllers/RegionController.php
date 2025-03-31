<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Regions\RegionCreateRequest;
use App\Http\Requests\Regions\RegionUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Region;

class RegionController extends Controller
{
    public function index(): Response
    {
        $regions = Region::all();

        return Inertia::render('regions/index', [
            'regions' => $regions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('regions/show');
    }

    public function store(RegionCreateRequest $request): RedirectResponse
    {
        $region = new Region();
        $region->fill($request->validated());
        $region->save();

        return to_route('regions.index');
    }

    public function edit(int $id): Response
    {
        $region = Region::findOrFail($id);

        return Inertia::render('regions/show', [
            'region' => $region,
        ]);
    }

    public function update(RegionUpdateRequest $request): RedirectResponse
    {
        $region = Region::findOrFail($request->id);
        $region->fill($request->validated());
        $region->save();

        return to_route('regions.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return to_route('regions.index');
    }
}
