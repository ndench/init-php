<?php

namespace app\Service;

use app\Client\GiphyClient;

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
        return $this->client->search($query);
    }
}
