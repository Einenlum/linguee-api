<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Factory;

use Einenlum\LingueeApi\Response\Transformer;
use Einenlum\LingueeApi\Response\Transformer\Word as WordTransformer;
use Einenlum\LingueeApi\Response\Transformer\Example as ExampleTransformer;
use Einenlum\LingueeApi\Query\UrlBuilder;
use Einenlum\LingueeApi\Response\Transformer\Word\Translations as TranslationTransformer;

abstract class ResponseTransformer
{
    private static function createWordTransformer(UrlBuilder $urlBuilder): WordTransformer
    {
        $translationTransformer = new TranslationTransformer($urlBuilder);

        return new WordTransformer($urlBuilder, $translationTransformer);
    }

    private static function createExampleTransformer(UrlBuilder $urlBuilder): ExampleTransformer
    {
        return new ExampleTransformer($urlBuilder);
    }

    public static function create(UrlBuilder $urlBuilder): Transformer
    {
        return new Transformer(
            self::createWordTransformer($urlBuilder),
            self::createExampleTransformer($urlBuilder)
        );
    }
}
