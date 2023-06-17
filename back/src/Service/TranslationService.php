<?php

namespace App\Service;

class TranslationService
{
    private $deepLService;
    private $englishCountries = [
        'United States' => 'États-Unis',
        'United Kingdom' => 'Royaume-Uni',
        'France' => 'France',
        'Germany' => 'Allemagne',
        'Canada' => 'Canada',
        'Australia' => 'Australie',
        'Japan' => 'Japon',
        'Italy' => 'Italie',
        'Spain' => 'Espagne',
        'China' => 'Chine',
        'India' => 'Inde',
        'Argentina' => 'Argentine',
        'Belgium' => 'Belgique',
        'Brazil' => 'Brésil',
        'Chile' => 'Chili',
        'Colombia' => 'Colombie',
        'Czech Republic' => 'République Tchèque',
        'Denmark' => 'Danemark',
        'Finland' => 'Finlande',
        'Hong Kong' => 'Hong Kong',
        'Hungary' => 'Hongrie',
        'Iceland' => 'Islande',
        'Ireland' => 'Irlande'
    ];
    private $isoCountries = [
        'US' => 'États-Unis',
        'GB' => 'Royaume-Uni',
        'FR' => 'France',
        'DE' => 'Allemagne',
        'CA' => 'Canada',
        'AU' => 'Australie',
        'JP' => 'Japon',
        'IT' => 'Italie',
        'ES' => 'Espagne',
        'CN' => 'Chine',
        'IN' => 'Inde',
        'AR' => 'Argentine',
        'BE' => 'Belgique',
        'BR' => 'Brésil',
        'CL' => 'Chili',
        'CO' => 'Colombie',
        'CZ' => 'République Tchèque',
        'DK' => 'Danemark',
        'FI' => 'Finlande',
        'HK' => 'Hong Kong',
        'HU' => 'Hongrie',
        'IS' => 'Islande',
        'IE' => 'Irlande',
        'NL' => 'Pays-Bas',
        'NZ' => 'Nouvelle-Zélande',
        'NO' => 'Norvège',
        'PL' => 'Pologne',
        'PT' => 'Portugal',
        'RU' => 'Russie',
        'SE' => 'Suède',
        'CH' => 'Suisse',
        'TR' => 'Turquie',
        'ZA' => 'Afrique du Sud',
        'AE' => 'Émirats Arabes Unis',
        'AF' => 'Afghanistan',
        'AL' => 'Albanie',
        'DZ' => 'Algérie',
        'AS' => 'Samoa Américaines',
        'AD' => 'Andorre',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctique',
        'AG' => 'Antigua-et-Barbuda',
        'AM' => 'Arménie',
        'AW' => 'Aruba',
        'AT' => 'Autriche',
        'AZ' => 'Azerbaïdjan',
        'BS' => 'Bahamas',
        'BH' => 'Bahreïn',
        'BD' => 'Bangladesh',
        'BB' => 'Barbade',
        'BY' => 'Biélorussie',
        'BZ' => 'Belize',
        'BJ' => 'Bénin',
    ];

    public function __construct(DeepLService $deepLService)
    {
        $this->deepLService = $deepLService;
    }

    public function translate(string $text, string $source = 'EN', string $target = 'FR'): string
    {
        return $this->deepLService->translate($source, $target, $text);
    }

    public function getFrenchCountryName(string $country): string
    {
        return $this->englishCountries[$country] ?? $this->deepLService->translate('EN', 'FR', $country);
    }

    public function getFrenchCountryNameByIso(string $iso): string
    {
        return $this->isoCountries[$iso] ?? '';
    }
}
