<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\DTO;

class Response
{
    public $query;
    public $words;
    public $examples;

    public function __construct(string $query, array $words, array $examples)
    {
        $this->query = $query;
        $this->words = $words;
        $this->examples = $examples;
    }

    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }

    public function toJson(): string
    {
        return json_encode($this);
    }
}
