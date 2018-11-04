<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Contract;

use Einenlum\LingueeApi\Response\DTO\Response;

interface Linguee
{
    /**
     * @param string $query The word to translate
     * @param string $shortFrom The short code for the language to translate from
     * @param string $shortTo The short code for the language to translate to
     *
     * @return Response
     *
     * Example: $linguee->translate('money', 'eng', 'por')
     */
    public function translate(string $query, string $shortFrom, string $shortTo): Response;
}
