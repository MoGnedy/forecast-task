<?php

declare(strict_types=1);

namespace Tests\MusementApi;

use App\Clients\MusementApiClient;
use PHPUnit\Framework\TestCase;

final class MusementGetCitiesTest extends TestCase
{

    public function testGetCities(): void
    {
        $musementApiClient = new MusementApiClient();
        $cities = $musementApiClient->getCities();

        $this->assertNotEmpty($cities);

        foreach ($cities as $city) {
            $this->assertObjectHasAttribute('name', $city);
            $this->assertObjectHasAttribute('latitude', $city);
            $this->assertObjectHasAttribute('longitude', $city);
        }
    }
}
