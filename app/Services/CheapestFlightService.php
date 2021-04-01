<?php

namespace App\Services;

use App\Exceptions\FlightNotFoundException;
use App\Exceptions\NoFlightCandidateFoundException;
use App\Repositories\AirportRepository;
use Illuminate\Support\Collection;

class CheapestFlightService
{
    /**
     * @var CheapestFlightFinder
     */
    private $findRoute;

    /**
     * @var Collection
     */
    private $airports;

    /**
     * @var array
     */
    private $flightCandidates;

    /**
     * @var string
     */
    private $sourceCity;

    /**
     * @var string
     */
    private $destinationCity;

    public function __construct(AirportRepository $airportRepository)
    {
        $this->airports = $airportRepository->getAirportsWithRoutes();
    }

    public function find(string $sourceCity, string $destinationCity)
    {
        $this->sourceCity = $sourceCity;
        $this->destinationCity = $destinationCity;
        $this->flightCandidates = [];

        $sourceAirports = $this->airports->where('city', $sourceCity);

        $this->findRoute = new CheapestFlightFinder(new AirportVisitor($this->airports->count()), $this->airports);

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
