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

    public function length(): int
    {
        return count($this->routes);
    }

    public function addRoute(Route $route): void
    {
        $this->routes[] = [
            'source' => $route->sourceAirport->city,
            'destination' => $route->destinationAirport->city,
            'price' => $route->price
        ];
    }

    public function toArray(): array
    {
        return [
            'routes' => $this->routes,
            'length' => $this->length(),
            'totalPrice' => $this->totalPrice()
        ];
    }
}
