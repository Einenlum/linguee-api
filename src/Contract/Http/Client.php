<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Contract\Http;

interface Client
{
    public function send(string $url): string;
}
