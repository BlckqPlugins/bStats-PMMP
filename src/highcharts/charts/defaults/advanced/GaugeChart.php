<?php
declare(strict_types=1);
namespace bStats\charts\defaults\advanced;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new GaugeChart("example", function() {
 *     return 75;  // Beispielwert für den Nadelstand
 * });
 * ```
 */
class GaugeChart extends CallbackChart {
    public static function getType(): string{ return "gauge"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
