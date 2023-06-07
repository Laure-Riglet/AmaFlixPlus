<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TmdbService
{
    private $apiToken;
    private $client;

    public function __construct(string $apiToken, HttpClientInterface $client)
    {
        $this->apiToken = $apiToken;
        $this->client = $client;
    }
    public function searchMatchingProductions(string $title): array
    {
        return $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/search/multi?query=' . $title . '&include_adult=false&language=fr-FR&page=1',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiToken,
                    'accept' => 'application/json',
                ]
            ]
        )->toArray();
    }
}
