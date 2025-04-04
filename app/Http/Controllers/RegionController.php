<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Regions\RegionCreateRequest;
use App\Http\Requests\Regions\RegionUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Region;

class RegionController extends Controller
{
    public function index(): Response
    {
        $regions = Region::whereNull('parent_id')
            ->with('children')
            ->get();

        return Inertia::render('regions/index', [
            'regions' => $regions,
        ]);
    }

    public function create(): Response
    {
        $regions = Region::whereNull('parent_id')->get();
        $users = User::all();

        return Inertia::render('regions/show', [
            'regions' => $regions,
            'users' => $users,
        ]);
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
        $region = Region::with('courts')->findOrFail($id);
        $regions = Region::whereNull('parent_id')
            ->whereNot('id', $id)
            ->get();
        $users = User::all();

        return Inertia::render('regions/show', [
            'region' => $region,
            'regions' => $regions,
            'users' => $users,
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
