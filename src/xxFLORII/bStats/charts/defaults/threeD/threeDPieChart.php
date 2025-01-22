<?php
declare(strict_types=1);
namespace xxFLORII\bStats\charts\defaults\threeD;
use xxFLORII\bStats\charts\CallbackChart;

/**
 * Example:
 * ```php
 * $chart = new threeDPieChart("example", function() {
 *     return [
 *         ["name" => "Category A", "y" => 50],
 *         ["name" => "Category B", "y" => 30],
 *         ["name" => "Category C", "y" => 20]
 *     ];
 * });
 * ```
 */
class threeDPieChart extends CallbackChart {
    public static function getType(): string{ return "3dpie"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
