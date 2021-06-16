<?php
require "./vendor/autoload.php";

use App\Adapters\CityForecastAdapter;
use App\Clients\{MusementApiClient, WeatherApiClient};

$musementApiClient = new MusementApiClient();
$cities = $musementApiClient->getCities();

$weatherApiClient = new WeatherApiClient('eb0d3f37cff6415d860141752211206');
$citiesForecast = $weatherApiClient->getCititsForecast($cities, 2);


$adaptedCities = [];

foreach ($citiesForecast as $city) {
    $adapter = new CityForecastAdapter($city);
    $adaptedCities[] = $adapter->adapte();
}


foreach ($adaptedCities as $cityForecast) {
    echo "Processed city " . ($cityForecast['name']) . " - " . ($cityForecast['forecast_days'][0]) . " | " . ($cityForecast['forecast_days'][1]) . ".\r\n";
    echo '<br>';
}
