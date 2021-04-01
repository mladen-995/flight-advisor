<?php

namespace App\Services\Flight;

class AirportVisitor
{
    /**
     * @var array
     */
    private $visitedAirports = [];

    /**
     * @var int
     */
    private $totalNumberOfAirports;

    public function __construct(int $totalNumberOfAirports)
    {
        $this->totalNumberOfAirports = $totalNumberOfAirports;
    }

    public function emptyVisitedAirports(): void
    {
        $this->visitedAirports = [];
    }

    public function visit(int $airportId): void
    {
        $this->visitedAirports[] = $airportId;
    }

    public function isAirportVisited(int $airportId): bool
    {
        return in_array($airportId, $this->visitedAirports);
    }
}
