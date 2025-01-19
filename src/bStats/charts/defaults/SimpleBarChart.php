<?php
declare(strict_types=1);
namespace bStats\charts\defaults;
use bStats\charts\CallbackChart;

/**
 ```php
$chart = new SimpleBarChart("example", function() {
    return [
        "Category 1" => 50,
        "Category 2" => 30,
        "Category 3" => 20,
    ];
);
 ```
 */
class SimpleBarChart extends CallbackChart {
    protected function getValue(): mixed{
        $values = [];
        $map = $this->call();
        if ($map === null || empty($map)) return null;
        foreach ($map as $key => $value) {
            $categoryValues = [];
            $categoryValues[] = $value;
            $values[$key] = $categoryValues;
        }
        return $values;
    }
}