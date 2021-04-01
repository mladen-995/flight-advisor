<?php

namespace App\Services\Flight;

use App\Models\Route;

class Flight
{
    /**
     * @var array
     */
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function totalPrice(): float
    {
        $totalPrice = 0;
        foreach($this->routes as $route) {
            $totalPrice += $route['price'];
        }

        return $totalPrice;
    }

    public function addRoute(Route $route): void
    {
        $this->routes[] = [
            'source' => $route->sourceAirport->city,
            'destination' => $route->destinationAirport->city,
            'price' => $route->price
        ];
    }
}
