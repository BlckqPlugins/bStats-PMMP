<?php
declare(strict_types=1);
namespace bStats\charts\defaults\other;
use bStats\charts\CallbackChart;

/**
 * Beispiel:
 * ```php
 * $chart = new SunburstChart("example", function() {
 *     return [
 *         ["name" => "Category 1", "children" => [
 *             ["name" => "Subcategory 1-1", "value" => 50],
 *             ["name" => "Subcategory 1-2", "value" => 30]
 *         ]],
 *         ["name" => "Category 2", "children" => [
 *             ["name" => "Subcategory 2-1", "value" => 70]
 *         ]]
 *     ];
 * });
 * ```
 */
class SunburstChart extends CallbackChart {
    public static function getType(): string{ return "sunburst"; }

    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
