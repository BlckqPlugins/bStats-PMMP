<?php
declare(strict_types=1);
namespace bStats\charts\defaults;
use bStats\charts\CallbackChart;

/**
 ```php
$chart = new SimplePieChart("example", function() {
    return "PieValue";
);
 ```
 */
class SimplePieChart extends CallbackChart {
    protected function getValue(): mixed{
        $value = $this->call();
        if ($value === null || $value === "") return null;
        $data['value'] = $value;
        return json_encode($data);
    }
}