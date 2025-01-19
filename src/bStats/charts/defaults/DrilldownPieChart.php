<?php
declare(strict_types=1);
namespace bStats\charts\defaults;
use bStats\charts\CallbackChart;

/**
 ```php
$chart = new DrilldownPieChart("example", function() {
    return [
        "Category 1" => [
            "SubCategory 1" => 15,
            "SubCategory 2" => 25,
        ],
        "Category2" => [
            "SubCategory 1" => 10,
            "SubCategory 3" => 20,
            "SubCategory 4" => 9,
        ],
    ];
);
 ```
 */
class DrilldownPieChart extends CallbackChart {
protected function getValue(): mixed{
        $values = [];
        $map = $this->call();
        if ($map === null || empty($map)) return null;
        $reallyAllSkipped = true;
        foreach ($map as $key => $entryValues) {
            $value = [];
            $allSkipped = true;
            foreach ($entryValues as $valueEntryKey => $valueEntryValue) {
                $value[$valueEntryKey] = $valueEntryValue;
                $allSkipped = false;
            }
            if (!$allSkipped) {
                $reallyAllSkipped = false;
                $values[$key] = $value;
            }
        }
        if ($reallyAllSkipped) return null;
        return $values;
    }
}
