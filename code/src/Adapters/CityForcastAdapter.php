<?php

namespace App\Adapters;

class CityForcastAdapter
{
    private $adaptee;

    public function __construct($adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function adapte()
    {
        return [
            'name' => $this->adaptee->location->name,
            'forecast_days' => array_map(fn ($forecastday) => $forecastday->day->condition->text, $this->adaptee->forecast->forecastday)
        ];
    }
}
