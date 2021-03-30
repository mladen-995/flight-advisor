<?php

namespace App\Services;

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
     * @var array
     */
    private $navigationToDestinationCity = [];

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

    public function __construct(AirportVisitor $airportVisitor, Collection $airports)
    {
        $this->airportVisitor = $airportVisitor;
        $this->airports = $airports;
    }

    public function findFlightFromAirportToCity(Airport $sourceAirport, string $destinationCity): Flight
    {
        $this->sourceAirport = $sourceAirport;
        $this->destinationCity = $destinationCity;

        $this->setSourceAirport($sourceAirport);
        $this->airportVisitor->emptyVisitedAirports();

        while(true) {
            $airportToVisit = $this->findNextCheapestAirportOrThrowException();

            $this->airportVisitor->visit($airportToVisit->id);

            if ($airportToVisit->city === $destinationCity) {
                return new Flight($this->navigationToDestinationCity[$airportToVisit->id]);
            }

            foreach($airportToVisit->sourceRoutes as $route) {
                $this->updatePriceAndPathToDestinationAirportIfNotVisited($route);
            }
        }
    }

    private function setSourceAirport(Airport $sourceAirport): void
    {
        $this->pricePerDestinationAirport[$sourceAirport->id] = 0;
        $this->navigationToDestinationCity[$sourceAirport->id] = [];
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

    private function updatePriceAndPathToDestinationAirportIfNotVisited(Route $route)
    {
        if ($this->airportVisitor->isAirportVisited($route->destination_airport_id)) {
            return;
        }

        $this->updatePriceToDestinationAirport($route);
        $this->updatePathToDestinationAirport($route);
    }

    private function updatePriceToDestinationAirport(Route $route): void
    {
        $this->pricePerDestinationAirport[$route->destination_airport_id] = $this->pricePerDestinationAirport[$route->source_airport_id] + $route->price;
    }

    private function updatePathToDestinationAirport(Route $route): void
    {
        $newPath = $this->navigationToDestinationCity[$route->source_airport_id];
        $newPath[] = [
            'source' => $route->sourceAirport->city,
            'destination' => $route->destinationAirport->city,
            'price' => $route->price
        ];
        $this->navigationToDestinationCity[$route->destination_airport_id] = $newPath;
    }
}
