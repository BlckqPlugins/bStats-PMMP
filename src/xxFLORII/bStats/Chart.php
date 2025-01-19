<?php

namespace xxFLORII\bStats;

abstract class Chart implements \JsonSerializable {

    /** @var string */
    private string $id;

    /** @var array */
    private array $values = [];

    public function __construct(string $id) {
        $this->id = $id;
    }

    /**
     * Get the chart ID.
     *
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * Add a value to the chart.
     *
     * @param mixed $value
     * @return void
     */
    public function addValue(mixed $value): void {
        $this->values[] = $value;
    }

    /**
     * Get all values of the chart.
     *
     * @return array
     */
    public function getValues(): array {
        return $this->values;
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @return array
     */
    public function jsonSerialize(): array {
        return [
            'chartId' => $this->id,
            'data' => $this->getValues()
        ];
    }
}