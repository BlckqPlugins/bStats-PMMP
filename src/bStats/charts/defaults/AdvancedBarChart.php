<?php
declare(strict_types=1);
namespace bStats\charts\defaults;
use bStats\charts\CallbackChart;

/**
 ```php
$chart = new AdvancedBarChart("example", function() {
    return [
        "Category 1" => [10, 20, 30],
        "Category 2" => [15, 25]
    ];
);
 ```
 */
class AdvancedBarChart extends CallbackChart {
    protected function getValue(): mixed{
        $values = [];
        $map = $this->call();
        if ($map === null || empty($map)) return null;
        $allSkipped = true;
        foreach ($map as $key => $valueArray) {
            if (empty($valueArray)) continue;
            $allSkipped = false;
            $categoryValues = [];
            foreach ($valueArray as $categoryValue) $categoryValues[] = $categoryValue;
            $values[$key] = $categoryValues;
        }
        if ($allSkipped) return null;
        return $values;
    }
}