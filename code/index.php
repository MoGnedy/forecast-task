<?php
require "./vendor/autoload.php";

use App\Clients\MusementApiClient;

$musementApiClient = new MusementApiClient();
$cities = $musementApiClient->getCities();


