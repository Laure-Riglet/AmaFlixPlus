<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class TextFormatService
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upperFirstEachWord(string $text): string
    {
        $text = strtolower($text);
        $text = str_replace('’', '\'', $text);
        $words = explode(' ', $text);

        $formattedText = '';

        foreach ($words as $word) {
            if ($word === $words[0] && str_contains($word, '\'')) {
                $word = explode('\'', $word);
                if (in_array($word[0], ['d', 'l', 'c', 'o'])) {
                    $word[0] = ucfirst($word[0]);
                    $word[1] = ucfirst($word[1]);
                } else {
                    $word[0] = ucfirst($word[0]);
                }
                $formattedText .= implode('\'', $word) . ' ';
            } else if ($word === $words[0]) {
                $formattedText .= ucfirst($word) . ' ';
            } else if (in_array($word, ['de', 'du', 'des', 'le', 'la', 'les', 'un', 'une', 'des', 'the', 'a', 'an', 'of']) && $word !== $words[0]) {
                $formattedText .= $word . ' ';
            } else if (str_contains($word, '\'')) {
                $word = explode('\'', $word);
                if (in_array($word[0], ['d', 'l', 'c'])) {
                    $word[1] = ucfirst($word[1]);
                } else if (in_array($word[0], ['o'])) {
                    $word[0] = ucfirst($word[0]);
                    $word[1] = ucfirst($word[1]);
                } else {
                    $word[0] = ucfirst($word[0]);
                }
                $formattedText .= implode('\'', $word) . ' ';
            } else if (str_contains($word, '-')) {
                $word = explode('-', $word);
                $word = array_map(function ($word) {
                    return ucfirst($word);
                }, $word);
                $formattedText .= implode('-', $word) . ' ';
            } else {
                $formattedText .= ucfirst($word) . ' ';
            }
        }

        return trim($formattedText);
    }

    public function upperFirst(string $text): string
    {
        return ucfirst($text);
    }

    public function slugify(string $text): string
    {
        return $this->slugger->slug($text)->lower();
    }
}