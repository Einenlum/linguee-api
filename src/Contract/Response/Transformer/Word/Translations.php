<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Contract\Response\Transformer\Word;

use Symfony\Component\DomCrawler\Crawler;

interface Translations
{
    public function getTranslations(Crawler $translationsLines): array;
}
