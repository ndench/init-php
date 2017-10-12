<?php

namespace app\Service;

use app\Client\GiphyClient;
use app\Model\Result;

class SearchService
{
    private $client;

    public function __construct(GiphyClient $client) 
    {
        $this->client = $client;
    }

    public function test(): string
    {
        return $this->client->test();
    }

    public function search(string $query): array
    {
        $response = $this->client->search($query);

        $results = [];
        foreach ($response['data'] as $r) {
            $res = new Result();
            $res->url = $r['images']['fixed_width']['url'];
            $results[] = $res;
        }

        return $results;
    }
}
