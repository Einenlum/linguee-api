<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\DTO\Response\Word;

class Translation
{
    public $term;
    public $audio;
    public $type;
    public $alternatives = [];
    public $examples = [];
}
