<?php

namespace src\oop\app\src\Transporters;

use GuzzleHttp\Client;
use src\oop\app\src\Helpers\Encoder;

class GuzzleAdapter implements TransportInterface
{
    private Client $client;
    private Encoder $encoder;
    
    public function __construct()
    {
        $this->client = new Client();
        $this->encoder = new Encoder();
    }
    
    public function getContent(string $url): string
    {
        $response = $this->client->request('GET', $url);
    
        $contentType = $response->getHeader('content-type')[0];
        $content = $response->getBody();
        
        return $this->encoder->encodeContent($content, $contentType);
    }
}