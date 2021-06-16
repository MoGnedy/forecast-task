<?php

namespace App\Clients;


class WeatherApiClient
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    const BASE_URL = 'http://api.weatherapi.com';
    const FORECAST_API = '/v1/forecast';

    protected function getEndPointUrl($endPoint, $dataFormat, $queryParamsArr)
    {
        $queryParams =  http_build_query($queryParamsArr);
        $citiesEndPoint = $endPoint . ".$dataFormat?key=" . $this->apiKey . ($queryParams ? "&$queryParams" : "");

        return self::BASE_URL . $citiesEndPoint;
    }


    protected function executeMultiCurl($multi, $channels)
    {
        // While we're still active, execute curl
        $active = null;
        do {
            $mrc = curl_multi_exec($multi, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK) {
            // Wait for activity on any curl-connection
            if (curl_multi_select($multi) == -1) {
                continue;
            }

            // Continue to exec until curl is ready to
            // give us more data
            do {
                $mrc = curl_multi_exec($multi, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }

        $data = [];
        // Loop through the channels and retrieve the received
        // content, then remove the handle from the multi-handle
        foreach ($channels as $channel) {
            $data[] = json_decode(curl_multi_getcontent($channel));
            curl_multi_remove_handle($multi, $channel);
        }

        // Close the multi-handle and return our results
        curl_multi_close($multi);

        return $data;
    }

    public function getCititsForecast($cities, $daysCount = 1)
    {
        $multi = curl_multi_init();
        $channels = array();
        foreach ($cities as $city) {

            $queryParamsArr =  [
                "q" => "$city->latitude,$city->longitude",
                "days" => $daysCount
            ];

            $url = $this->getEndPointUrl(self::FORECAST_API, 'json', $queryParamsArr);

            $channel = curl_init();
            curl_setopt($channel, CURLOPT_URL, $url);
            curl_setopt($channel, CURLOPT_HEADER, false);
            curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);

            curl_multi_add_handle($multi, $channel);

            $channels[$url] = $channel;
        }

        $citiesForecast = $this->executeMultiCurl($multi, $channels);

        return $citiesForecast;
    }
}
