<?php

namespace App\Services;

use App\Exceptions\FlightNotFoundException;
use App\Models\Airport;
use App\Exceptions\NoFlightCandidateFoundException;

class CheapestFlightService
{
    private $findRoute;

    private array $flightCandidates;

    private string $sourceCity;
    private string $destinationCity;

    public function find(string $sourceCity, string $destinationCity): Flight
    {
        $this->sourceCity = $sourceCity;
        $this->destinationCity = $destinationCity;
        $this->flightCandidates = [];

        $airports = Airport::select('id', 'name', 'city')->with('sourceRoutes:source_airport_id,destination_airport_id,price')->get();

        $sourceAirports = $airports->where('city', $sourceCity);

        $this->findRoute = new CheapestFlightFinder(new AirportVisitor($airports->count()), $airports);

        foreach($sourceAirports as $sourceAirport) {
            try {
                $this->flightCandidates[] = $this->findRoute->findFlightFromAirportToCity($sourceAirport, $destinationCity);
            } catch (FlightNotFoundException $exception) {
                continue;
            }

        }

        return $this->getCheapestFlightFromFoundCandidates();
    }

    private function getCheapestFlightFromFoundCandidates(): Flight
    {
        $minPrice = null;

        foreach ($this->flightCandidates as $flightCandidate) {
            if ($minPrice === null || $flightCandidate->totalPrice() < $minPrice) {
                return $flightCandidate;
            }
        }

        throw new NoFlightCandidateFoundException($this->sourceCity, $this->destinationCity);
    }
}
