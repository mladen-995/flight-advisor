<?php

namespace App\Console\Commands;

use App\Models\Airport;
use App\Models\Route;
use Illuminate\Console\Command;

class ImportRoutes extends Command
{
    protected $signature = 'import-routes';

    public function handle()
    {
        $airportsIds = Airport::pluck('id')->toArray();

        $file = fopen(storage_path("app/routes.txt"), "r");

        while(!feof($file)) {
            $line = fgets($file);
            $route = explode(',', trim($line));

            if ($line == null) {
                continue;
            }

            if (!$this->shouldRouteBeCreated($route, $airportsIds)) {
                continue;
            }

            Route::firstOrCreate([
                'airline' => str_replace("\"", '', $route[0]),
                'airline_id' => str_replace("\"", '', $route[1]),
                'source_airport' => str_replace("\"", '', $route[2]),
                'source_airport_id' => str_replace("\"", '', $route[3]),
                'destination_airport' => str_replace("\"", '', $route[4]),
                'destination_airport_id' => str_replace("\"", '', $route[5]),
                'codeshare' => str_replace("\"", '', $route[6]),
                'stops' => str_replace("\"", '', $route[7]),
                'equipment' => str_replace("\"", '', $route[8]),
                'price' => str_replace("\"", '', $route[9]),
            ]);
        }

        fclose($file);
    }

    private function shouldRouteBeCreated(array $route, array $airportsIds): bool
    {
        return in_array(str_replace("\"", '', $route[3]), $airportsIds) &&
            in_array(str_replace("\"", '', $route[5]), $airportsIds);
    }
}
