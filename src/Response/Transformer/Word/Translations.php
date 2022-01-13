<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\Transformer\Word;

use Symfony\Component\DomCrawler\Crawler;
use Einenlum\LingueeApi\Response\DTO\Response\Word\Translation as TranslationDTO;
use Einenlum\LingueeApi\Response\DTO\Response\Word\Translation\Alternative as AlternativeDTO;
use Einenlum\LingueeApi\Query\UrlBuilder;
use Einenlum\LingueeApi\Response\DTO\Response\Word\Translation\Example as ExampleDTO;
use Einenlum\LingueeApi\Contract\Response\Transformer\Word\Translations as TranslationsInterface;

class Translations implements TranslationsInterface
{
    private $urlBuilder;

    public function __construct(UrlBuilder $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    private function getTranslation(Crawler $translationContainer): TranslationDTO
    {
        $translationDescription = $translationContainer->filter('.translation_desc');

        $getTerm = function () use ($translationDescription) {
            $termContainer = $translationDescription
                ->filter('.tag_trans a.dictLink')
            ;

            return $termContainer->count()
                ? ($termContainer->text() ?? null)
                : null
            ;
        };

        $getType = function () use ($translationDescription) {
            $tagTransContainer = $translationDescription
              ->children()->reduce(function (Crawler $node, $i) {
                  return false !== strpos($node->attr('class'), 'tag_trans');
              });

            if (!$tagTransContainer->count()) {
                return null;
            }

            $typeContainer = $tagTransContainer->children()->reduce(function (Crawler $node, $i) {
                return false !== strpos($node->attr('class'), 'tag_type');
            });

            return $typeContainer->count()
              ? ($typeContainer->text() ?? null)
              : null
          ;
        };

        $getAudio = function () use ($translationDescription) {
            $audio = $translationDescription->filter('.tag_trans a.audio');
            $audioPath = $audio->count()
              ? ($audio->attr('id') ?? null)
              : null
          ;

            return $audioPath
              ? $this->urlBuilder->buildAudio($audioPath)
              : null
            ;
        };

        $getAlternatives = function () use ($translationDescription) {
            $getAlternative = function ($altTagContainer) {
                $termContainer = $altTagContainer->filter('.formLink');
                $term = $termContainer->getNode(0) ? $termContainer->text() : null;

                $typeContainer = $altTagContainer->filter('.tag_type');
                $type = $typeContainer->getNode(0) ? $typeContainer->text() : null;

                return new AlternativeDTO($term, $type);
            };

            $altTagsContainer = $translationDescription->filter('.tag_forms .tag_t');

            return $altTagsContainer->each(function (Crawler $node) use ($getAlternative) {
                return $getAlternative($node);
            });
        };

        $getExamples = function () use ($translationContainer) {
            $getExample = function ($exampleLine) {
                $container = $exampleLine->filter('.tag_e');

                $from = $container->filter('.tag_s')->text();
                $to = $container->filter('.tag_t')->text();

                return new ExampleDTO($from, $to);
            };
            $exampleLines = $translationContainer->filter('.example_lines .line');

            return $exampleLines->each(function (Crawler $exampleLine) use ($getExample) {
                return $getExample($exampleLine);
            });
        };

        $translation = new TranslationDTO();
        $translation->term = $getTerm();
        $translation->audio = $getAudio();
        $translation->type = $getType();
        $translation->alternatives = $getAlternatives();
        $translation->examples = $getExamples();

        return $translation;
    }

    public function getTranslations(Crawler $translationsLines): array
    {
        return $translationsLines->each(function (Crawler $node) {
            return $this->getTranslation($node);
        });
    }
}
