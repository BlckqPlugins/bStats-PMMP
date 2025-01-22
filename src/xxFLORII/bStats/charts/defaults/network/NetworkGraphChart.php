<?php
declare(strict_types=1);
namespace xxFLORII\bStats\charts\defaults\network;
use xxFLORII\bStats\charts\CallbackChart;

/**
 * Example:
 * ```php
 * $chart = new NetworkGraphChart("example", function() {
 *     return [
 *         ["from" => "A", "to" => "B", "value" => 10],
 *         ["from" => "B", "to" => "C", "value" => 20],
 *         ["from" => "C", "to" => "D", "value" => 30]
 *     ];
 * });
 * ```
 */
class NetworkGraphChart extends CallbackChart {
    public static function getType(): string{ return "networkgraph"; }
    protected function getValue(): mixed{
        $value = $this->call();
        if (empty($value)) return null;
        return $value;
    }
}
