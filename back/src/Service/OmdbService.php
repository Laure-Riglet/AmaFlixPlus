<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbService
{
    private $apiKey;
    private $client;

    public function __construct(string $apiKey, HttpClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * Returns one production from its id or title
     *
     * @param   string    $type
     * @param   string    $value
     * @return  array
     */
    public function searchByImdbIdOrTitle(string $type, string $value, ?int $year = null): array
    {
        $imdbId = $type === 'id' ? $value : '';
        $title = $type === 'title' ? $value : '';

        return $this->client->request(
            'GET',
            'http://www.omdbapi.com/?i=' . $imdbId . '&apikey=' . $this->apiKey . '&t=' . $title . '&y=' . $year,
            [
                'headers' => [
                    'accept' => 'application/json',
                ]
            ]
        )->toArray();
    }
}