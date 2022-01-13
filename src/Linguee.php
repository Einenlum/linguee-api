<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi;

use Einenlum\LingueeApi\Http\Client;
use Einenlum\LingueeApi\Response\Transformer as ResponseTransformer;
use Einenlum\LingueeApi\Response\DTO\Response;
use Einenlum\LingueeApi\Query\UrlBuilder;
use Einenlum\LingueeApi\Config\Language as LanguageConfig;
use Einenlum\LingueeApi\Contract\Linguee as LingueeInterface;

class Linguee implements LingueeInterface
{
    private ResponseTransformer $responseTransformer;
    private Client $client;
    private UrlBuilder $urlBuilder;
    private LanguageConfig $languageConfig;

    public function __construct(
        UrlBuilder $urlBuilder,
        ResponseTransformer $responseTransformer,
        Client $client,
        LanguageConfig $languageConfig
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->responseTransformer = $responseTransformer;
        $this->languageConfig = $languageConfig;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $query, string $shortFrom, string $shortTo): Response
    {
        $from = $this->languageConfig->getLanguage($shortFrom);
        $to = $this->languageConfig->getLanguage($shortTo);

        $url = $this->urlBuilder->build($query, $from, $to);
        $responseBody = $this->client->send($url);

        return $this->responseTransformer->transform($responseBody, $query);
    }
}
