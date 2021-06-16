<?php

namespace App\Clients;

class MusementApiClient
{

    const BASE_URL = 'https://sandbox.musement.com';
    const CITIES_API = '/api/v3/cities';


    public function getCities()
    {
        //open connection
        $ch = curl_init(self::BASE_URL . self::CITIES_API);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $response = curl_exec($ch);

        $data = curl_error($ch) ? null : json_decode($response);

        curl_close($ch);

        return $data;
    }
}
