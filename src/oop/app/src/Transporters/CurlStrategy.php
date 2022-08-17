<?php

namespace src\oop\app\src\Transporters;

use Exception;
use src\oop\app\src\Helpers\Encoder;

class CurlStrategy implements TransportInterface
{
    private Encoder $encoder;
    
    public function __construct()
    {
        $this->encoder = new Encoder();
    }
    
    public function getContent(string $url): string
    {
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $html = curl_exec($ch);
        
        curl_close($ch);
        
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 429) {
            throw new Exception('429 Too Many Requests');
        }
        
        return $this->encoder->encodeContent($html, curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
    }
}