<?php

namespace App\Service;

use DateTime;
use Faker\Provider\ar_EG\Text;

class ProductionRetrievalService
{
    private $tmdbService;
    private $omdbService;
    private $translationService;
    private $TextFormatService;

    public function __construct(
        TmdbService $tmdbService,
        OmdbService $omdbService,
        TranslationService $translationService,
        TextFormatService $TextFormatService
    ) {
        $this->tmdbService = $tmdbService;
        $this->omdbService = $omdbService;
        $this->translationService = $translationService;
        $this->TextFormatService = $TextFormatService;
    }

    /**
     * Returns one production from its id or title
     *
     * @param   string    $type
     * @param   string    $value
     * @return  array
     */
    public function search($title): array
    {
        // First, we search for the matching productions on TMDB
        $rawTmdbSearchResults = $this->tmdbService->searchMulti($title);

        $searchResults = [];

        foreach ($rawTmdbSearchResults['results'] as $rawTmdbSearchResult) {

            // If the result is a person, we skip it
            if ($rawTmdbSearchResult['media_type'] === 'person') {
                continue;
            }

            $rawTmdbResultDetails = $this->tmdbService->getDetails($rawTmdbSearchResult['media_type'], $rawTmdbSearchResult['id']);

            $searchResult = [
                'media_type' => $rawTmdbSearchResult['media_type'], // 'movie', 'tv', 'person'
                'tmdb_id' => $rawTmdbResultDetails['id'],
                'title' => $this->TextFormatService->upperFirstEachWord($rawTmdbSearchResult['title'] ?? $rawTmdbSearchResult['name']),
                'original_title' => $this->TextFormatService->upperFirstEachWord($rawTmdbResultDetails['original_title'] ?? $rawTmdbResultDetails['original_name']),
                'summary' => $this->translationService->translate($rawTmdbSearchResult['overview']),
                'release_date' => $rawTmdbResultDetails['release_date'] ?? $rawTmdbResultDetails['first_air_date'],
            ];

            $tmdbReleaseDate = DateTime::createFromFormat('Y-m-d', $searchResult['release_date']);

            if ($tmdbReleaseDate === false) {
                $rawOmdbResultDetails = [];
            } else {
                $rawOmdbResultDetails = $this->omdbService->searchByImdbIdOrTitle('title', $searchResult['original_title'], $tmdbReleaseDate->format('Y'));
            }

            // Retrieve the poster path
            $searchResult['poster_path'] = '';
            if (isset($rawTmdbResultDetails['poster_path']) && !empty($rawTmdbResultDetails['poster_path'])) {
                $searchResult['poster_path'] = 'https://www.themoviedb.org/t/p/w600_and_h900_bestv2' . $rawTmdbResultDetails['poster_path'];
            } else if (isset($rawOmdbResultDetails['Poster']) && !empty($rawOmdbResultDetails['Poster'])) {
                $searchResult['poster_path'] = $rawOmdbResultDetails['Poster'];
            }

            // Retrieve the imdb id
            $searchResult['imdb_id'] = 'unknown';

            if (isset($rawTmdbResultDetails['imdb_id'])) {
                $searchResult['imdb_id'] = $rawTmdbResultDetails['imdb_id'];
            } else {
                if (!isset($rawOmdbResultDetails['Released'])) {
                    continue;
                }

                $omdbReleaseDate = DateTime::createFromFormat('d M Y', $rawOmdbResultDetails['Released']);

                if (gettype($tmdbReleaseDate) !== 'object' || gettype($omdbReleaseDate) !== 'object') {
                    continue;
                }

                $interval = $omdbReleaseDate->diff($tmdbReleaseDate);
                $daysDifference = $interval->days;

                if ($daysDifference <= 3) {
                    $searchResult['imdb_id'] = $rawOmdbResultDetails['imdbID'];
                }
            }

            if ($searchResult['imdb_id'] === '') {
                $searchResult['imdb_id'] = 'unknown';
            }

            $searchResult['country'] = $this->translationService->getFrenchCountryName($rawOmdbResultDetails['Country'] ?? '');

            if ($searchResult['country'] === '') {
                if (isset($rawTmdbResultDetails['production_countries'][0])) {
                    foreach ($rawTmdbResultDetails['production_countries'] as $key => $productionCountry) {
                        $searchResult['country'] .= $this->translationService->getFrenchCountryNameByIso($productionCountry['iso_3166_1']) . ', ';
                    }
                    $searchResult['country'] = substr($searchResult['country'], 0, -2);
                } else {
                    $searchResult['country'] = 'Inconnu';
                }
            }

            $searchResults[] = $searchResult;
        }

        return $searchResults;
    }
}
