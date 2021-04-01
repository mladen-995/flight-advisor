<?php

namespace App\Console\Commands;

use App\Models\Airport;
use App\Models\City;
use Illuminate\Console\Command;

class ImportAirports extends Command
{
    protected $signature = 'import-airports';

    public function handle()
    {
        $cities = City::pluck('name')->toArray();

        $file = fopen(storage_path("app/airports.txt"), "r");

        while(!feof($file)) {
            $line = fgets($file);
            $airport = explode(',', trim($line));

            if ($line == null || !in_array(str_replace("\"", '', $airport[2]), $cities)) {
                continue;
            }

            Airport::firstOrCreate([
                'id' => $airport[0],
                'name' => str_replace("\"", '', $airport[1]),
                'city' => str_replace("\"", '', $airport[2]),
                'country' => str_replace("\"", '', $airport[3]),
                'iata' => str_replace("\"", '', $airport[4]),
                'icao' => str_replace("\"", '', $airport[5]),
                'latitude' => $airport[6],
                'longitude' => $airport[7],
                'altitude' => $airport[8],
                'timezone' => $airport[9],
                'dst' => str_replace("\"", '', $airport[10]),
                'tz' => str_replace("\"", '', $airport[11]),
                'type' => str_replace("\"", '', $airport[12]),
                'source' => str_replace("\"", '', $airport[13]),
            ]);
        }

        fclose($file);
    }
}
