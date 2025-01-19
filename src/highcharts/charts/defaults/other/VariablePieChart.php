<?php
declare(strict_types=1);
namespace bStats\charts\defaults\other;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new VariablePieChart("example", function() {
 *     return [
 *         ["name" => "Category A", "value" => 50],
 *         ["name" => "Category B", "value" => 30],
 *         ["name" => "Category C", "value" => 20]
 *     ];
 * });
 * ```
 */
class VariablePieChart extends CallbackChart {
    public static function getType(): string{ return "variablepie"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
