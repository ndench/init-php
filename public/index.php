<?php

require_once __DIR__.'/../vendor/autoload.php';

use app\Client\GiphyClient;
use app\Service\SearchService;

$giphy = new GiphyClient();
$search = new SearchService($giphy);

if (!isset($_GET['q'])) {
    echo 'Please specify q as a GET parameter';
    die();
}

$query = $_GET['q'];

header('Content-Type: application/json');
echo json_encode($search->search($query));

