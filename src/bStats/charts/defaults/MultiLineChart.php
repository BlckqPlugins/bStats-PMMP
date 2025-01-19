<?php
declare(strict_types=1);
namespace bStats\charts\defaults;
use bStats\charts\CallbackChart;

/**
 ```php
$chart = new MultiLineChart("example", function() {
    return [
        "Line 1" => 100,
        "Line 2" => 200,
        "Line 3" => 300,
    ];
);
 ```
 */
class MultiLineChart extends CallbackChart {
    protected function getValue(): mixed{
        $values = [];
        $map = $this->call();
        if ($map === null || empty($map)) return null;

        $allSkipped = true;
        foreach ($map as $key => $value) {
            if ($value == 0) continue;
            $allSkipped = false;
            $values[$key] = $value;
        }
        if ($allSkipped) return null;
        $data["values"] = $values;
        return $data;
    }
}