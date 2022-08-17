<?php

namespace src\oop\app\src\Parsers;

use src\oop\app\src\Models\Movie;

class FilmixParserStrategy implements ParserInterface
{
    /**
     * @param  string  $siteContent
     * @return mixed
     */
    public function parseContent(string $siteContent)
    {
        $movie = new Movie();
        
        preg_match('~<h1.*?>(.*?)</h1>~ius', $siteContent, $matches);
        $movie->setTitle($matches[1]);
    
        preg_match('~<a\sclass="fancybox".+?href="(.+?)"~ius', $siteContent, $matches);
        $movie->setPoster($matches[1]);
    
        preg_match('~<div\sclass="full-story">(.+?)</div>~iu', $siteContent, $matches);
        $movie->setDescription($matches[1]);
        
        return $movie;
    }
}