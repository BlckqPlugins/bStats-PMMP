<?php
declare(strict_types=1);
namespace xxFLORII\bStats\charts\defaults\stock;
use xxFLORII\bStats\charts\CallbackChart;

/**
 * Example:
 * ```php
 * $chart = new RangeChart("example", function() {
 *     return [
 *         ["x" => "2023-01-01", "low" => 90, "high" => 120],
 *         ["x" => "2023-01-02", "low" => 105, "high" => 125]
 *     ];
 * });
 * ```
 */
class RangeChart extends CallbackChart {
    public static function getType(): string{ return "range"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
