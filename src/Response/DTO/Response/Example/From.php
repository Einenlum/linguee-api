<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\DTO\Response\Example;

class From
{
    public $content;
    public $type;
    public $audio;

    public function __construct(string $content)
    {
        $this->content = $content;
    }
}
