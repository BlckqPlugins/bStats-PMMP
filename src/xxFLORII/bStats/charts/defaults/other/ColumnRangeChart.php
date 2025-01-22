<?php
declare(strict_types=1);
namespace xxFLORII\bStats\charts\defaults\other;
use xxFLORII\bStats\charts\CallbackChart;

/**
 * Example:
 * ```php
 * $chart = new ColumnRangeChart("example", function() {
 *     return [
 *         ["x" => 1, "low" => 5, "high" => 15],
 *         ["x" => 2, "low" => 10, "high" => 25],
 *         ["x" => 3, "low" => 15, "high" => 35]
 *     ];
 * });
 * ```
 */
class ColumnRangeChart extends CallbackChart {
    public static function getType(): string{ return "columnrange"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
