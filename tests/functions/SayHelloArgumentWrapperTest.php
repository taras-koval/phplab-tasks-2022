<?php

namespace functions;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SayHelloArgumentWrapperTest extends TestCase
{
    protected Functions $functions;
    
    protected function setUp(): void
    {
        $this->functions = new Functions();
    }
    
    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->functions->sayHelloArgumentWrapper([1, 2, 3]);
    }
}