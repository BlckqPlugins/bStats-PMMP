<?php
declare(strict_types=1);
namespace bStats\charts\defaults\other;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new PolarChart("example", function() {
 *     return [
 *         ["name" => "Point A", "value" => 50],
 *         ["name" => "Point B", "value" => 30],
 *         ["name" => "Point C", "value" => 20]
 *     ];
 * });
 * ```
 */
class PolarChart extends CallbackChart {
    public static function getType(): string{ return "polar"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
