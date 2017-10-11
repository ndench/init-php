<?php

require_once __DIR__.'/../vendor/autoload.php';

use app\Client\GiphyClient;
use app\Service\SearchService;

$giphy = new GiphyClient();
$search = new SearchService($giphy);

echo $search->test();

