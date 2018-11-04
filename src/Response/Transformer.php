<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response;

use Einenlum\LingueeApi\Response\DTO\Response;
use Symfony\Component\DomCrawler\Crawler;
use Einenlum\LingueeApi\Response\Transformer\Word as WordTransformer;
use Einenlum\LingueeApi\Response\Transformer\Example as ExampleTransformer;
use Einenlum\LingueeApi\Contract\Response\Transformer as TransformerInterface;

class Transformer implements TransformerInterface
{
    private $wordTransformer;
    private $exampleTransformer;

    public function __construct(WordTransformer $wordTransformer, ExampleTransformer $exampleTransformer)
    {
        $this->wordTransformer = $wordTransformer;
        $this->exampleTransformer = $exampleTransformer;
    }

    private function getWords(Crawler $container): array
    {
        $wordsContainer = $container->filter('.lemma');
        $words = $wordsContainer->each(function (Crawler $wordContainer, $i) {
            return $this->wordTransformer->getWord($wordContainer);
        });

        return $words;
    }

    private function getExamples(Crawler $container): array
    {
        $examplesContainer = $container->filter('.example_lines .lemma');
        $examples = $examplesContainer->each(function (Crawler $exampleContainer, $i) {
            return $this->exampleTransformer->getExample($exampleContainer);
        });

        return $examples;
    }

    public function transform(string $html, string $query): Response
    {
        $body = new Crawler($html);
        $container = $body->filter('.exact');

        return new Response(
            $query,
            $this->getWords($container),
            $this->getExamples($body)
        );
    }
}
