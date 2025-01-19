<?php
declare(strict_types=1);
namespace bStats\charts\defaults\stock;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new FlagsChart("example", function() {
 *     return [
 *         ["x" => "2023-01-01", "title" => "Flag 1", "text" => "Event A"],
 *         ["x" => "2023-02-01", "title" => "Flag 2", "text" => "Event B"]
 *     ];
 * });
 * ```
 */
class FlagsChart extends CallbackChart {
    public static function getType(): string{ return "flags"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
