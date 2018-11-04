<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Contract\Response;

use Einenlum\LingueeApi\Response\DTO\Response;

interface Transformer
{
    public function transform(string $html, string $query): Response;
}
