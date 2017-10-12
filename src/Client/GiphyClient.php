<?php

namespace app\Client;

class GiphyClient
{
    private $apiKey = '31mQtVEv26389QKDEoonDB9YtSTZwWGw';

    public function test(): string
    {
        return 'giphy';
    }

    public function search(string $query): array
    {
        $params = "api_key={$this->apiKey}&q=$query&limit=5";
        $url = "https://api.giphy.com/v1/gifs/search?$params";
        return json_decode(file_get_contents($url), true);
    }
}
