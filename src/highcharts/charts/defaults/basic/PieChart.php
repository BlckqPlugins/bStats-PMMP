<?php
declare(strict_types=1);
namespace bStats\charts\defaults\basic;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new PieChart("example", function() {
 *     return [
 *         ["name" => "A", "y" => 40],
 *         ["name" => "B", "y" => 30],
 *         ["name" => "C", "y" => 30]
 *     ];
 * });
 * ```
 */
class PieChart extends CallbackChart {
    public static function getType(): string{ return "pie"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
