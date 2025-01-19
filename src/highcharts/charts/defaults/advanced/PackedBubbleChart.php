<?php
declare(strict_types=1);
namespace bStats\charts\defaults\advanced;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new PackedBubbleChart("example", function() {
 *     return [
 *         ["name" => "A", "value" => 10, "z" => 5],
 *         ["name" => "B", "value" => 20, "z" => 8],
 *         ["name" => "C", "value" => 30, "z" => 12]
 *     ];
 * });
 * ```
 */
class PackedBubbleChart extends CallbackChart {
    public static function getType(): string{ return "packedbubble"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
