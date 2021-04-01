<?php

namespace App\Services\Flight;

use App\Exceptions\FlightNotFoundException;
use App\Models\Airport;
use App\Models\Route;
use Illuminate\Support\Collection;

class CheapestFlightFinder
{
    /**
     * @var array
     */
    private $pricePerDestinationAirport = [];

    /**
     * @var Airport
     */
    private $sourceAirport;

    /**
     * @var string
     */
    private $destinationCity;

    /**
     * @var Collection
     */
    private $airports;

    /**
     * @var AirportVisitor
     */
    private $airportVisitor;

    /**
     * @var FlightCollection
     */
    private $flightCollection;

    public function __construct(AirportVisitor $airportVisitor, Collection $airports)
    {
        $this->airportVisitor = $airportVisitor;
        $this->airports = $airports;
    }

    public function findFlightFromAirportToCity(Airport $sourceAirport, string $destinationCity): Flight
    {
        $this->sourceAirport = $sourceAirport;
        $this->destinationCity = $destinationCity;

        $this->flightCollection = new FlightCollection();
        $this->setSourceAirport($sourceAirport);
        $this->airportVisitor->emptyVisitedAirports();

        while(true) {
            $airportToVisit = $this->findNextCheapestAirportOrThrowException();

            $this->airportVisitor->visit($airportToVisit->id);

            if ($airportToVisit->city === $destinationCity) {
                return $this->flightCollection->getFlightToDestinationAirport($airportToVisit->id);
            }

            foreach($airportToVisit->sourceRoutes as $route) {
                $this->updatePriceAndPathToDestinationAirportIfNotVisited($route);
            }
        }
    }

    private function setSourceAirport(Airport $sourceAirport): void
    {
        $this->pricePerDestinationAirport[$sourceAirport->id] = 0;
        $this->flightCollection->setStartingPoint($sourceAirport->id);
    }

    private function findNextCheapestAirportOrThrowException(): ?Airport
    {
        $nextAirportId = $minPrice = null;

        foreach ($this->pricePerDestinationAirport as $airportId => $price) {
            if ($this->airportVisitor->isAirportVisited($airportId)) {
                continue;
            }

            if ($minPrice == null || $minPrice < $price) {
                $nextAirportId = $airportId;
                $minPrice = $price;
            }
        }

        if ($nextAirportId === null) {
            throw new FlightNotFoundException($this->sourceAirport, $this->destinationCity);
        }

        return $this->airports->find($nextAirportId);
    }

    private function updatePriceAndPathToDestinationAirportIfNotVisited(Route $route): void
    {
        if ($this->airportVisitor->isAirportVisited($route->destination_airport_id)) {
            return;
        }

        $this->updatePriceToDestinationAirport($route);
        $this->flightCollection->addFlightWithRoute($route);
    }

    private function updatePriceToDestinationAirport(Route $route): void
    {
        $this->pricePerDestinationAirport[$route->destination_airport_id] =
            $this->pricePerDestinationAirport[$route->source_airport_id] + $route->price;
    }
}
