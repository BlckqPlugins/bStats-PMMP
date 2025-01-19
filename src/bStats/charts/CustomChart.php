<?php
declare(strict_types=1);
namespace bStats\charts;

abstract class CustomChart implements \JsonSerializable{
    private string $custom_id;

    public function __construct(string $custom_id) {
        assert($custom_id !== null, new \InvalidArgumentException("Chart: \$custom_id cannot be null"));
        $this->custom_id = $custom_id;
    }
    public function getCustomId(): string{ return $this->custom_id; }

    public function jsonSerialize(): array{
        $json = [
            "chartId" => $this->custom_id,
        ];
        try {
            $data = $this->getValue();
            if ($data === null) throw new \ErrorException("\$data cannot be null");
            $json["data"] = $data;
        } catch (\Throwable $ignored) {
        }
        return $json;
    }

    /**
     * Generiert die Diagrammdaten.
     *
     * @return null|mixed - data ODER null=Diagramm überspringen
     * @throws \Exception
     */
    protected abstract function getValue(): mixed;
}
