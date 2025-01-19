<?php
declare(strict_types=1);
namespace bStats\charts\defaults;
use bStats\charts\CallbackChart;

/**
 ```php
$chart = new SingleLineChart("example", function() {
    return 123;
);
 ```
 */
class SingleLineChart extends CallbackChart {
    protected function getValue(): mixed{
        $value = $this->call();
        if ($value == 0) return null;
        return $value;
    }
}
