<?php

namespace App\Services\Flight;

use App\Models\Route;

class FlightCollection
{
    /**
     * @var array
     */
    private $flights;

    public function setStartingPoint(int $airportId): void
    {
        $this->addFlightWithDestinationAirportToCollection(new Flight([]), $airportId);
    }

    public function addFlightWithRoute(Route $route): void
    {
        $flightToSource = $this->getFlightToAirport($route->source_airport_id);

        $flightToDestination = clone $flightToSource;
        $flightToDestination->addRoute($route);

        $this->addFlightWithDestinationAirportToCollection($flightToDestination, $route->destination_airport_id);
    }

    public function getFlightToDestinationAirport(int $airportId): Flight
    {
        return $this->flights[$airportId];
    }

    private function getFlightToAirport(int $airportId): Flight
    {
        return $this->flights[$airportId];
    }

    private function addFlightWithDestinationAirportToCollection(Flight $flight, int $destinationAirportId): void
    {
        $this->flights[$destinationAirportId] = $flight;
    }
}
