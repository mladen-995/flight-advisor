<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindFlightRequest;
use App\Services\CheapestFlightService;
use App\Services\CheapestPathService;

class CheapestFlightController extends Controller
{
    private CheapestFlightService $cheapestFlightService;

    public function __construct(CheapestFlightService $cheapestFlightService)
    {
        $this->cheapestFlightService = $cheapestFlightService;
    }

    public function findFlight(FindFlightRequest $request)
    {
        return $this->cheapestFlightService->find($request->source_city, $request->destination_city)->getRoutes();
    }
}
