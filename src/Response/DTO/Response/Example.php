<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\DTO\Response;

class Example
{
    public $from;
    public $tos;

    public function __construct($from, $tos)
    {
        $this->from = $from;
        $this->tos = $tos;
    }
}
