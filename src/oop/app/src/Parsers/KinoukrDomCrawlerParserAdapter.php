<?php

namespace src\oop\app\src\Parsers;

use src\oop\app\src\Models\Movie;
use Symfony\Component\DomCrawler\Crawler;

class KinoukrDomCrawlerParserAdapter implements ParserInterface
{
    /**
     * @param  string  $siteContent
     * @return mixed
     */
    public function parseContent(string $siteContent)
    {
        $crawler = new Crawler($siteContent);
        $movie = new Movie();
    
        $movie->setTitle($crawler->filter('h1')->text());
        $movie->setPoster($crawler->filter('.fposter a')->link()->getUri());
        $movie->setDescription($crawler->filter('#fdesc')->text());
        
        return $movie;
    }
}