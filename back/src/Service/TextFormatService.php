<?php

namespace App\Service;

class TextFormatService
{
    public function upperFirstEachWord(string $text): string
    {
        $text = strtolower($text);
        $words = explode(' ', $text);

        $formattedText = '';

        foreach ($words as $word) {

            if (in_array($word, ['de', 'du', 'des', 'le', 'la', 'les', 'un', 'une', 'des', 'the', 'a', 'an', 'of']) && $word !== $words[0]) {
                $formattedText .= $word . ' ';
            } elseif (str_contains($word, '-')) {
                $word = explode('-', $word);
                $word = array_map(function ($word) {
                    return ucfirst($word);
                }, $word);
                $formattedText .= implode('-', $word) . ' ';
            } else {
                $formattedText .= ucfirst($word) . ' ';
            }
        }

        return $formattedText;
    }

    public function upperFirst(string $text): string
    {
        return ucfirst($text);
    }
}