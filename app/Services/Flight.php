<?php

namespace App\Services;

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
}
