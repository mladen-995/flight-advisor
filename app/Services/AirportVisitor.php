<?php

namespace App\Services;

use Illuminate\Support\Collection;

class AirportVisitor
{
    private array $visitedAirports = [];

    private int $totalNumberOfAirports;

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
