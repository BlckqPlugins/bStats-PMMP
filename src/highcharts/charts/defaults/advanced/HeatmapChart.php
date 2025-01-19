<?php
declare(strict_types=1);
namespace bStats\charts\defaults\advanced;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new HeatmapChart("example", function() {
 *     return [
 *         [1, 2, 3, 4],
 *         [5, 6, 7, 8],
 *         [9, 10, 11, 12]
 *     ];
 * });
 * ```
 */
class HeatmapChart extends CallbackChart {
    public static function getType(): string{ return "heatmap"; }

    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
