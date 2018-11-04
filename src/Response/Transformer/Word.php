<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Response\Transformer;

use Symfony\Component\DomCrawler\Crawler;
use Einenlum\LingueeApi\Response\DTO\Response\Word as WordDTO;
use Einenlum\LingueeApi\Query\UrlBuilder;
use Einenlum\LingueeApi\Response\Transformer\Word\Translations as TranslationTransformer;
use Einenlum\LingueeApi\Contract\Response\Transformer\Word as WordInterface;

class Word implements WordInterface
{
    private $urlBuilder;
    private $translationTransformer;

    public function __construct(UrlBuilder $urlBuilder, TranslationTransformer $translationTransformer)
    {
        $this->urlBuilder = $urlBuilder;
        $this->translationTransformer = $translationTransformer;
    }

    private function getTerm(Crawler $mainDescription): ?string
    {
        $termContainer = $mainDescription->filter('a.dictLink');
                                         
        return $termContainer->count() ? $termContainer->text() : null;
    }

    private function getAdditionalInformation(Crawler $mainDescription): ?string
    {
        $additionalInfoContainer = $mainDescription->filter('.tag_lemma_context');
        return $additionalInfoContainer->count()
          ? ($additionalInfoContainer->text() ?? null)
          : null;
    }

    private function getType(Crawler $mainDescription): ?string
    {
        $typeContainer = $mainDescription->filter('.tag_wordtype');

        return $typeContainer->getNode(0)
            ? ($typeContainer->text() ?? null)
            : null
        ;
    }

    private function getAudio(Crawler $mainDescription): ?string
    {
        $audioContainer = $mainDescription->filter('a.audio');
        if (!$audioContainer->getNode(0)) {
            return null;
        }

        $audioPath = $audioContainer
            ? ($audioContainer->attr('id') ?? null)
            : null
        ;

        return $audioPath
            ? $this->urlBuilder->buildAudio($audioPath)
            : null
        ;
    }

    private function getMainDescription(Crawler $wordContainer): Crawler
    {
        return $wordContainer->filter('.lemma_desc .tag_lemma');
    }

    public function getWord(Crawler $wordContainer): WordDTO
    {
        $mainDescription = $this->getMainDescription($wordContainer);
        $translationsContainer = $wordContainer->filter(
            '.lemma_content .translation_lines'
        );

        $dto = new WordDTO();

        $dto->term = $this->getTerm($mainDescription);
        $dto->additionalInformation = $this->getAdditionalInformation($mainDescription);
        $dto->type = $this->getType($mainDescription);
        $dto->audio = $this->getAudio($mainDescription);
        $dto->translations = $this
            ->translationTransformer
            ->getTranslations($translationsContainer)
        ;

        return $dto;
    }
}
