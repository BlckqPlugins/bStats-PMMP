<?php
declare(strict_types=1);
namespace bStats\charts\defaults\other;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new SolidGaugeChart("example", function() {
 *     return 75;
 * });
 * ```
 */
class SolidGaugeChart extends CallbackChart {
    public static function getType(): string{ return "solidgauge"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if ($value === null || $value === "") return null;
        return $value;
    }
}
