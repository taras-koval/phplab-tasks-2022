<?php

namespace arrays;

class Arrays implements ArraysInterface
{
    /**
     * @inheritDoc
     */
    public function repeatArrayValues(array $input): array
    {
        $output = [];
        
        foreach ($input as $value) {
            $output = array_merge($output, array_fill(0, $value, $value));
        }
        
        return $output;
    }
    
    /**
     * @inheritDoc
     */
    public function getUniqueValue(array $input): int
    {
        $input = array_filter(array_count_values($input), function ($item) {
            return $item === 1;
        });
    
        return $input ? min(array_keys($input)) : 0;
    }
    
    /**
     * @inheritDoc
     */
    public function groupByTag(array $input): array
    {
        $output = [];
        
        array_multisort($input);
    
        foreach($input as $sub) {
            foreach($sub['tags'] as $tag) {
                $output[$tag][] = $sub['name'];
            }
        }
        
        return $output;
    }
}