<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Query;

use Einenlum\LingueeApi\Contract\Query\UrlBuilder as UrlBuilderInterface;

class UrlBuilder implements UrlBuilderInterface
{
    private $domain;
    private $placeholderUrl;
    private $queryParameters;

    public function __construct(
        string $domain,
        string $placeholderUrl,
        array $queryParameters
    ) {
        $this->domain = $domain;
        $this->placeholderUrl = $placeholderUrl;
        $this->queryParameters = $queryParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function build(string $query, string $from, string $to): string
    {
        return sprintf(
            '%s/%s?%s',
            rtrim($this->domain, '/'),
            ltrim(str_replace(
                ['{from}', '{to}'],
                [$from, $to],
                $this->placeholderUrl
            ), '/'),
            http_build_query(
                array_merge($this->queryParameters, ['query' => $query])
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildAudio(string $path): string
    {
        return sprintf(
            '%s/mp3/%s',
            rtrim($this->domain, '/'),
            ltrim($path, '/')
        );
    }
}
