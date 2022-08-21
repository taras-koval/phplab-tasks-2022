<?php

namespace web;

use PHPUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, getUniqueFirstLetters($input));
    }
    
    public function positiveDataProvider(): array
    {
        return [[
            [
                ["name" => "Austin Bergstrom International Airport"],
                ["name" => "Charleston International Airport"],
                ["name" => "Denver International"],
                ["name" => "Indianapolis International Airport"],
                ["name" => "Kansas City International Airport"],
                ["name" => "Miami International Airport"],
                ["name" => "St. Louis - Lambert International Airport"],
                ["name" => "Kahului Airport"],
                ["name" => "Atlantic City Airport"],
                ["name" => "Alexandria International Airport"],
            ],
            ['A', 'C', 'D', 'I', 'K', 'M', 'S']
        ]];
    }
}