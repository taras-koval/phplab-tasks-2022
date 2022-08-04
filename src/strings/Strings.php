<?php

namespace strings;

class Strings implements StringsInterface
{
    public function snakeCaseToCamelCase(string $input): string
    {
        return lcfirst(str_replace('_', '', ucwords($input, '_')));
    }
    
    public function mirrorMultibyteString(string $input): string
    {
        $words = explode(' ', $input);
    
        foreach ($words as &$word) {
            $chars = mb_str_split($word);
            $word = implode('', array_reverse($chars));
        }
    
        return implode(' ', $words);
    }
    
    public function getBrandName(string $noun): string
    {
        if (substr($noun, 0, 1) === substr($noun, -1)) {
            return ucfirst($noun . substr($noun, 1));
        }
    
        return 'The ' . ucfirst($noun);
    }
}