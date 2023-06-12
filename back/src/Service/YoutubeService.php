<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class YoutubeService
{
    private $apiKey;
    private $client;

    public function __construct(string $apiKey, HttpClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * Returns a list of yt of french trailers for a given query
     *
     * @param   string    $type
     * @param   string    $value
     * @return  array
     */
    public function search(string $query): array
    {
        return $this->client->request(
            'GET',
            'https://www.googleapis.com/youtube/v3/search?key=' . $this->apiKey . '&part=snippet&q=' . $query . ' VF trailer',
            [
                'headers' => [
                    'accept' => 'application/json',
                ]
            ]
        )->toArray();
    }
}