<?php
declare(strict_types=1);
namespace bStats\charts\defaults\advanced;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new BubbleChart("example", function() {
 *     return [
 *         ["x" => 1, "y" => 2, "z" => 5],
 *         ["x" => 3, "y" => 4, "z" => 10],
 *         ["x" => 5, "y" => 6, "z" => 15]
 *     ];
 * });
 * ```
 */
class BubbleChart extends CallbackChart {
    public static function getType(): string{ return "bubble"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
