<?php
require "./vendor/autoload.php";

use App\Adapters\CityForcastAdapter;
use App\Clients\{MusementApiClient, WeatherApiClient};

$musementApiClient = new MusementApiClient();
$cities = $musementApiClient->getCities();

$weatherApiClient = new WeatherApiClient('eb0d3f37cff6415d860141752211206');
$citiesForcast = $weatherApiClient->getCitiesForcast($cities, 2);


$adaptedCities = [];

foreach ($citiesForcast as $city) {
    $adapter = new CityForcastAdapter($city);
    $adaptedCities[] = $adapter->adapte();
}

