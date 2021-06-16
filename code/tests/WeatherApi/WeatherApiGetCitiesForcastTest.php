<?php

declare(strict_types=1);

namespace Tests\WeatherApi;

use App\Clients\WeatherApiClient;
use PHPUnit\Framework\TestCase;

final class WeatherApiGetCitiesForcastTest extends TestCase
{
    const API_KEY = 'eb0d3f37cff6415d860141752211206';

    protected function getCitiesSampleData()
    {
        return         [
            (object) [
                'latitude' => 52.374,
                'longitude' => 4.9
            ],
            (object)[
                'latitude' => 48.866,
                'longitude' => 2.355
            ]
        ];
    }

    public function testgetCitiesForcast(): void
    {

        $cities = $this->getCitiesSampleData();

        $weatherApiClient = new WeatherApiClient(self::API_KEY);
        $citiesForcast = $weatherApiClient->getCitiesForcast($cities, 2);

        $this->assertNotEmpty($citiesForcast);

        foreach ($citiesForcast as $city) {
            $this->assertObjectHasAttribute('location', $city);
            $this->assertObjectHasAttribute('forecast', $city);
        }
    }
}
