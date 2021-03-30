<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Requests\CitySearchRequest;
use App\Http\Requests\CityStoreRequest;
use App\Http\Resources\CityResource;
use App\Models\City;

class CityController extends Controller
{
    public function index(CitySearchRequest $request)
    {
        $query = City::with('comments');

        if ($request->exists('name')) {
            $query->where('name', 'like', sprintf('%%%s%%', $request->input('name')));
        }

        return CityResource::collection($query->get());
    }

    public function store(CityRequest $request)
    {
        return response()->json(City::create($request->validated()), 201);
    }
}
