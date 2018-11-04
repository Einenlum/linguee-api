<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\DTO\Response\Word\Translation;

class Alternative
{
    public $term;
    public $type;

    public function __construct(?string $term = null, ?string $type = null)
    {
        $this->term = $term;
        $this->type = $type;
    }
}
