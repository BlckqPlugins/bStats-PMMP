<?php
declare(strict_types=1);
namespace xxFLORII\bStats\charts\defaults\advanced;
use xxFLORII\bStats\charts\CallbackChart;

/**
 * Example:
 * ```php
 * $chart = new WaterfallChart("example", function() {
 *     return [
 *         ["name" => "Start", "y" => 0],
 *         ["name" => "Revenue", "y" => 50],
 *         ["name" => "Cost", "y" => -20],
 *         ["name" => "Profit", "y" => 30],
 *     ];
 * });
 * ```
 */
class WaterfallChart extends CallbackChart {
    public static function getType(): string{ return "waterfall"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
