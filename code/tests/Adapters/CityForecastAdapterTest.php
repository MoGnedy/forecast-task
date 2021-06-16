<?php

declare(strict_types=1);

namespace Tests\Adapters;

use App\Adapters\CityForecastAdapter;
use PHPUnit\Framework\TestCase;

final class CityForecastAdapterTest extends TestCase
{

    private function getCityForecastData()
    {
        return
            (object)[
                'location' => (object) [
                    'name' => 'Berlin'
                ],
                'forecast' =>  (object)[
                    'forecastday' =>  [

                        (object)[
                            'day' => (object)[
                                'condition' => (object) [
                                    'text' => 'Moderate rain'
                                ]
                            ]
                        ],
                        (object)[
                            'day' => (object)[
                                'condition' => (object) [
                                    'text' => 'Heavy rain'
                                ]
                            ]
                        ]

                    ]
                ]
            ];
    }

    public function testAdapteCity(): void
    {

        $city = $this->getCityForecastData();

        $adapter = new CityForecastAdapter($city);
        $adaptedCity = $adapter->adapte();

        $this->assertIsArray($adaptedCity);
        $this->assertArrayHasKey('name', $adaptedCity);
        $this->assertArrayHasKey('forecast_days', $adaptedCity);
        $this->assertIsArray($adaptedCity['forecast_days']);
        $this->assertCount(2, $adaptedCity['forecast_days']);
    }
}
