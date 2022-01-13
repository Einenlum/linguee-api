<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\Transformer;

use Symfony\Component\DomCrawler\Crawler;
use Einenlum\LingueeApi\Response\DTO\Response\Example as ExampleDTO;
use Einenlum\LingueeApi\Response\DTO\Response\Example\From as FromDTO;
use Einenlum\LingueeApi\Response\DTO\Response\Example\To as ToDTO;
use Einenlum\LingueeApi\Query\UrlBuilder;
use Einenlum\LingueeApi\Contract\Response\Transformer\Example as ExampleInterface;

class Example implements ExampleInterface
{
    private $urlBuilder;

    public function __construct(UrlBuilder $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    public function getExample(Crawler $exampleContainer): ExampleDTO
    {
        return new ExampleDTO(
            $this->getFrom($exampleContainer),
            $this->getTos($exampleContainer)
        );
    }

    private function getTos(Crawler $exampleContainer): array
    {
        $tosContainer = $exampleContainer->filter('.lemma_content .line .translation');

        $getTo = function ($toContainer) {
            $content = $toContainer->filter('a.dictLink')->text();
            $typeContainer = $toContainer->filter('.tag_type');

            $type = $typeContainer->getNode(0) ? $typeContainer->text() : null;

            $to = new ToDTO($content);
            $to->type = $type;

            return $to;
        };

        $tosContainer = $exampleContainer->filter('.lemma_content .line .translation');

        return $tosContainer->each(function (Crawler $node) use ($getTo) {
            return $getTo($node);
        });
    }

    private function getFrom(Crawler $exampleContainer): FromDTO
    {
        $fromContainer = $exampleContainer->filter('.lemma_desc .tag_lemma');

        $getAudio = function ($fromContainer) {
            $audioContainer = $fromContainer->filter('a.audio');
            $audioPath = $audioContainer->getNode(0) ? $audioContainer->attr('id') : null;

            return $audioPath ? $this->urlBuilder->buildAudio($audioPath) : null;
        };

        $content = $fromContainer->filter('a')->text();
        $typeContainer = $fromContainer->filter('.tag_type');
        $type = $typeContainer->count() ? $typeContainer->text() : null;

        $from = new FromDTO($content);
        $from->type = $type;
        $from->audio = $getAudio($fromContainer);

        return $from;
    }
}
