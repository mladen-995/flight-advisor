<?php

namespace App\Exceptions;

use Exception;

class NoFlightCandidateFoundException extends \Exception
{
    public function __construct(string $sourceCity, string $destinationCity)
    {
        parent::__construct(sprintf("There is no flight available from %s to %s.", $sourceCity, $destinationCity));
    }
}
