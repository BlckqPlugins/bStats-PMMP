<?php

namespace xxFLORII\bStats;

abstract class Chart {

    /** @var string */
    private $id;

    public function __construct(string $id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @return mixed
     */
    abstract public function getValue(): mixed;
}