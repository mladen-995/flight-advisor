<?php

namespace Tests\Feature;

use App\Models\Airport;
use App\Models\Route;
use App\Services\CheapestFlightService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheapestFlightTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_find_cheapest_flight_from_two_available()
    {
        $sourceCity = 'Source city';
        $destinationCity = 'Destination city';

        $sourceAirport = Airport::factory()->create([
            'city' => $sourceCity,
        ]);

        $airportsOnTheWay = Airport::factory()->count(2)->create();

        $destinationAirport = Airport::factory()->create([
            'city' => $destinationCity,
        ]);

        $r1 = Route::factory()->create([
            'source_airport_id' => $sourceAirport->id,
            'destination_airport_id' => $airportsOnTheWay->first()->id,
            'price' => 10.14
        ]);

        $r2 = Route::factory()->create([
            'source_airport_id' => $airportsOnTheWay->first()->id,
            'destination_airport_id' => $destinationAirport->id,
            'price' => 18.12
        ]);

        $r3 = Route::factory()->create([
            'source_airport_id' => $sourceAirport->id,
            'destination_airport_id' => $airportsOnTheWay->last()->id,
            'price' => 12.36
        ]);

        $r4 = Route::factory()->create([
            'source_airport_id' => $airportsOnTheWay->last()->id,
            'destination_airport_id' => $destinationAirport->id,
            'price' => 5.32
        ]);


        $service = app(CheapestFlightService::class);

        $result = $service->find('Source city', 'Destination city');
        $routes = $result->getRoutes();

        $this->assertEquals(2, count($routes));

        $this->assertEquals([
            'source' => $sourceCity,
            'destination' => $airportsOnTheWay->last()->city,
            'price' => $r3->price,
        ], $routes[0]);

        $this->assertEquals([
            'source' => $airportsOnTheWay->last()->city,
            'destination' => $destinationCity,
            'price' => $r4->price,
        ], $routes[1]);
    }
}
