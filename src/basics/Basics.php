<?php

namespace basics;

use InvalidArgumentException;

class Basics implements BasicsInterface
{
    private BasicsValidator $validator;
    
    public function __construct($validator)
    {
        $this->validator = $validator;
    }
    
    public function getMinuteQuarter(int $minute): string
    {
        $this->validator->isMinutesException($minute);
        
        if ($minute > 0 && $minute <= 15) {
            return 'first';
        }
        
        if ($minute > 15 && $minute <= 30) {
            return 'second';
        }
        
        if ($minute > 30 && $minute <= 45) {
            return 'third';
        }
        
        return 'fourth';
    }
    
    public function isLeapYear(int $year): bool
    {
        $this->validator->isYearException($year);
    
        return $year % 400 === 0 || ($year % 100 !== 0 && $year % 4 === 0);
    }
    
    public function isSumEqual(string $input): bool
    {
        $this->validator->isValidStringException($input);
    
        $firstSum = $input[0] + $input[1] + $input[2];
        $secondSum = $input[3] + $input[4] + $input[5];
    
        return $firstSum === $secondSum;
    }
}