<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response;

use Einenlum\LingueeApi\Response\DTO\Response;
use Einenlum\LingueeApi\Response\DTO\Response\Example;
use Einenlum\LingueeApi\Response\DTO\Response\Word;
use Symfony\Component\DomCrawler\Crawler;
use Einenlum\LingueeApi\Response\Transformer\Word as WordTransformer;
use Einenlum\LingueeApi\Response\Transformer\Example as ExampleTransformer;
use Einenlum\LingueeApi\Contract\Response\Transformer as TransformerInterface;

class Transformer implements TransformerInterface
{
    private WordTransformer $wordTransformer;
    private ExampleTransformer $exampleTransformer;

    public function __construct(WordTransformer $wordTransformer, ExampleTransformer $exampleTransformer)
    {
        $this->wordTransformer = $wordTransformer;
        $this->exampleTransformer = $exampleTransformer;
    }

    /** @return Word[] */
    private function getWords(Crawler $container): array
    {
        $wordsContainer = $container->filter('.lemma');
        $words = $wordsContainer->each(function (Crawler $wordContainer, $i) {
            return $this->wordTransformer->getWord($wordContainer);
        });

        return $words;
    }

    /** @return Example[] */
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
        /*
         * Here we use the addHtmlContent instead of using the constructor because
         * Symfony Dom Crawler automatically detects the encoding when using the last one.
         * Linguee officially uses ISO-8859-15 but seems to actually use UTF-8.
         */
        $body = new Crawler();
        $body->addHtmlContent($html);
        $container = $body->filter('.exact');

        return new Response(
            $query,
            $this->getWords($container),
            $this->getExamples($body)
        );
    }
}
