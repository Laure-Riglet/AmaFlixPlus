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

    public function searchMulti(string $title): array
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

    public function getDetails(string $type, int $tmdb_id)
    {
        return $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/' . $type . '/' . $tmdb_id,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiToken,
                    'accept' => 'application/json'
                ]
            ]
        )->toArray();
    }
}