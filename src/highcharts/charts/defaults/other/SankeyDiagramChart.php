<?php
declare(strict_types=1);
namespace bStats\charts\defaults\other;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new SankeyDiagramChart("example", function() {
 *     return [
 *         ["from" => "A", "to" => "B", "value" => 10],
 *         ["from" => "B", "to" => "C", "value" => 20],
 *         ["from" => "C", "to" => "D", "value" => 30]
 *     ];
 * });
 * ```
 */
class SankeyDiagramChart extends CallbackChart {
    public static function getType(): string{ return "sankey"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
