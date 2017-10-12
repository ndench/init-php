<?php

require_once __DIR__.'/../vendor/autoload.php';

use app\Client\GiphyClient;
use app\Service\SearchService;
use app\Model\Result;

$giphy = new GiphyClient();
$search = new SearchService($giphy);

$response = $search->search('cats');
$result1 = new Result();
$result1->url = "https://media2.giphy.com/media/Ov5NiLVXT8JEc/200w.gif";
$result2 = new Result();
$result2->url = "https://media0.giphy.com/media/W3QKEujo8vztC/200w.gif";
$result3 = new Result();
$result3->url = "https://media3.giphy.com/media/10rW4Xw9eO0RmU/200w.gif";
$result4 = new Result();
$result4->url = "https://media0.giphy.com/media/9JLQKmspQAMWQ/200w.gif";
$result5 = new Result();
$result5->url = "https://media2.giphy.com/media/5xaOcLwCCJURSCvXBte/200w.gif";

$expected = [$result1, $result2, $result3, $result4, $result5];

$pass = true;
foreach ($expected as $id => $value) {
    if ($value != $response[$id]) {
        echo "Expected {$response[$id]} got $value\n";
        $pass = false;
    }
}

if ($pass) {
    echo "PASSED\n";
} else {
    echo "FAILED\n";
}
