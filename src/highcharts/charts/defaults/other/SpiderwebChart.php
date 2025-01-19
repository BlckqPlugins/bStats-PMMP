<?php
declare(strict_types=1);
namespace bStats\charts\defaults\other;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new SpiderwebChart("example", function() {
 *     return [
 *         ["name" => "Metric A", "value" => 80],
 *         ["name" => "Metric B", "value" => 60],
 *         ["name" => "Metric C", "value" => 40],
 *         ["name" => "Metric D", "value" => 70]
 *     ];
 * });
 * ```
 */
class SpiderwebChart extends CallbackChart {
    public static function getType(): string{ return "spiderweb"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
