<?php
declare(strict_types=1);
namespace bStats\charts\defaults\map;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new TileMapChart("example", function() {
 *     return [
 *         ["hc-key" => "US", "value" => 5],
 *         ["hc-key" => "DE", "value" => 3],
 *         ["hc-key" => "FR", "value" => 2]
 *     ];
 * });
 * ```
 */
class TileMapChart extends CallbackChart {
    public static function getType(): string{ return "tilemap"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
