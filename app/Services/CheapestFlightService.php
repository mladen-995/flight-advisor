<?php

namespace App\Services;

use App\Exceptions\FlightNotFoundException;
use App\Exceptions\NoFlightCandidateFoundException;
use App\Repositories\AirportRepository;
use App\Services\Flight\AirportVisitor;
use App\Services\Flight\CheapestFlightFinder;
use App\Services\Flight\Flight;
use Illuminate\Support\Collection;

class CheapestFlightService
{
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

    public function find(string $sourceCity, string $destinationCity): Flight
    {
        $this->sourceCity = $sourceCity;
        $this->destinationCity = $destinationCity;
        $this->flightCandidates = [];

        $sourceAirports = $this->airports->where('city', $sourceCity);

        $flightFinder = new CheapestFlightFinder(new AirportVisitor($this->airports->count()), $this->airports);

        foreach($sourceAirports as $sourceAirport) {
            $this->appendFlightCandidateIfAvailable($flightFinder, $sourceAirport, $destinationCity);
        }

        return $this->getCheapestFlightFromFoundCandidates();
    }

    private function appendFlightCandidateIfAvailable(
        CheapestFlightFinder $findRoute,
        $sourceAirport,
        string $destinationCity
    ): void
    {
        try {
            $this->flightCandidates[] = $findRoute->findFlightFromAirportToCity($sourceAirport, $destinationCity);
        } catch (FlightNotFoundException $exception) {
            return;
        }
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
