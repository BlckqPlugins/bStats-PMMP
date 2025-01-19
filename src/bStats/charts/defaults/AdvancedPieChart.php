<?php
declare(strict_types=1);
namespace bStats\charts\defaults;
use bStats\charts\CallbackChart;


/**
 ```php
$chart = new AdvancedPieChart("example", function() {
    return [
        "Pie 1" => 50,
        "Pie 2" => 30,
        "Pie 3" => 20,
    ];
);
 ```
 */
class AdvancedPieChart extends CallbackChart {
    protected function getValue(): mixed{
        $data = [];
        $values = [];
        $map = ($this->callback)();
        if ($map === null || empty($map)) return null;
        $allSkipped = true;
        foreach ($map as $key => $value) {
            if ($value === 0) continue;
            $allSkipped = false;
            $values[$key] = $value;
        }
        if ($allSkipped) return null;
        return $values;
    }
}