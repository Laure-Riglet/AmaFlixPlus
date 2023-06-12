<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DeepLService
{
    private $apiKey;
    private $client;

    public function __construct(string $apiKey, HttpClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    public function translate(string $sourceLang, string $targetLang, string $text): string
    {
        $response = $this->client->request(
            'POST',
            'https://api-free.deepl.com/v2/translate',
            [
                'headers' => [
                    'Authorization' => 'DeepL-Auth-Key ' . $this->apiKey,
                    'accept' => 'application/json',
                ],
                'body' => [
                    'source_lang' => $sourceLang,
                    'target_lang' => $targetLang,
                    'text' => $text,
                ]
            ]
        )->toArray();

        return $response['translations'][0]['text'] ?? '';
    }
}