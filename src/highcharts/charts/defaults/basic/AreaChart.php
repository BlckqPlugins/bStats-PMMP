<?php
declare(strict_types=1);
namespace bStats\charts\defaults\basic;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new AreaChart("example", function() {
 *     return [
 *         "x" => [1, 2, 3, 4],
 *         "y" => [10, 15, 20, 25]
 *     ];
 * });
 * ```
 */
class AreaChart extends CallbackChart {
    public static function getType(): string{ return "area"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
