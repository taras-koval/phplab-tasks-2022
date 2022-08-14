<?php

namespace functions;

use PHPUnit\Framework\TestCase;

class sayHelloTest extends TestCase
{
    protected Functions $functions;
    
    protected function setUp(): void
    {
        $this->functions = new Functions();
    }
    
    public function testPositive()
    {
        $this->assertEquals('Hello', $this->functions->sayHello());
    }
}