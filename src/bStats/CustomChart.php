<?php
declare(strict_types=1);
namespace bStats;

abstract class CustomChart implements \JsonSerializable{
    private string $chart_id;

    public function __construct(string $chart_id) {
        assert($chart_id !== null, new InvalidArgumentException("\$chart_id cannot be null"));
        $this->chart_id = $chart_id;
    }
    public function getCustomId(): string{ return $this->id; }


    public function jsonSerialize(): array{
        $json = [
            "chartId" => $this->chart_id,
        ];
        try {
            $data = getChartData();
            if ($data == null) {
                return null;
            }
            $json["data"] = $data;
        } catch (\Throwable $t) {
        }
        return $json;
    }

    public abstract function getChartData(): array;
}
