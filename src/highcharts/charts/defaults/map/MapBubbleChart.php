<?php
declare(strict_types=1);
namespace bStats\charts\defaults\map;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new MapBubbleChart("example", function() {
 *     return [
 *         ["hc-key" => "US", "value" => 50, "z" => 10],
 *         ["hc-key" => "DE", "value" => 30, "z" => 8],
 *         ["hc-key" => "FR", "value" => 20, "z" => 6]
 *     ];
 * });
 * ```
 */
class MapBubbleChart extends CallbackChart {
    public static function getType(): string{ return "mapbubble"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
