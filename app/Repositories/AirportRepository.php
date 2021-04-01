<?php

namespace App\Repositories;

use App\Models\Airport;
use Illuminate\Support\Collection;

class AirportRepository
{
    /**
     * @var Airport
     */
    private $model;

    public function __construct(Airport $model)
    {
        $this->model = $model;
    }

    public function getAirportsWithRoutes(): Collection
    {
        return $this->model
            ->select('id', 'name', 'city')
            ->with('sourceRoutes:source_airport_id,destination_airport_id,price')
            ->get();
    }
}
