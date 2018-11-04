<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Contract\Response\Transformer;

use Symfony\Component\DomCrawler\Crawler;
use Einenlum\LingueeApi\Response\DTO\Response\Example as ExampleDTO;

interface Example
{
    public function getExample(Crawler $exampleContainer): ExampleDTO;
}
