<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Contract\Response\Transformer;

use Symfony\Component\DomCrawler\Crawler;
use Einenlum\LingueeApi\Response\DTO\Response\Word as WordDTO;

interface Word
{
    public function getWord(Crawler $wordContainer): WordDTO;
}
