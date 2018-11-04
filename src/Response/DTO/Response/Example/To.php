<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\DTO\Response\Example;

class To
{
    public $content;
    public $type;

    public function __construct(string $content)
    {
        $this->content = $content;
    }
}
