<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Requests\CityStoreRequest;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        return City::all();
    }

    public function store(CityRequest $request)
    {
        return response()->json(City::create($request->validated()), 201);
    }
}
