<?php

namespace App\Exceptions;

use App\Models\Airport;
use Exception;

class FlightNotFoundException extends Exception
{
    public function __construct(Airport $sourceAirport, string $destinationCity)
    {
        parent::__construct(sprintf(
            "Flight from airport id:%s to city %s can not be found.",
            $sourceAirport->id,
            $destinationCity
        ));
    }
}
