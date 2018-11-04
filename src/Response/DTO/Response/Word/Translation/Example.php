<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\DTO\Response\Word\Translation;

class Example
{
    public $from;
    public $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
}
