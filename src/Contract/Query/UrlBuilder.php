<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Contract\Query;

interface UrlBuilder
{
    /**
     * @param string $query The word or expression to translate
     * @param string $from The language to translate from
     * @param string $to The language to translate to
     *
     * @return string The full url that is built to send to the client
     */
    public function build(string $query, string $from, string $to): string;

    /**
     * @param string $path The relative path to the sound file
     *
     * @return string The full absolute path to the sound file
     */
    public function buildAudio(string $path): string;
}
