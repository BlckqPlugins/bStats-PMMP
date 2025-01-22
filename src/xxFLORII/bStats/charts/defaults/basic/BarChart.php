<?php
declare(strict_types=1);
namespace xxFLORII\bStats\charts\defaults\basic;
use xxFLORII\bStats\charts\CallbackChart;

/**
 ```php
$chart = new BarChart("example", function() {
    return [5, 10, 15, 20];
 });
 ```
 */
class BarChart extends CallbackChart {
    public static function getType(): string{ return "bar"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
