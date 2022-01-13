<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi;

use Einenlum\LingueeApi\Linguee;
use Einenlum\LingueeApi\Http\Client;
use Buzz\Client\FileGetContents;
use Buzz\Browser;
use Einenlum\LingueeApi\Query\UrlBuilder;
use Einenlum\LingueeApi\Response\Transformer as ResponseTransformer;
use Einenlum\LingueeApi\Config\Language as LanguageConfig;
use Einenlum\LingueeApi\Factory\ResponseTransformer as ResponseTransformerFactory;
use Nyholm\Psr7\Factory\Psr17Factory;

abstract class Factory
{
    private static $config;

    private static function createClient(): Client
    {
        $client = new FileGetContents(new Psr17Factory());
        $browser = new Browser($client, new Psr17Factory());

        return new Client($browser);
    }

    private static function getConfig(): array
    {
        if (empty(self::$config)) {
            self::$config = require_once(__DIR__.'/../config.php');
        }

        return self::$config;
    }

    private static function getLanguageConfig(): LanguageConfig
    {
        return new LanguageConfig(self::getConfig()['languages']);
    }

    private static function createUrlBuilder(): UrlBuilder
    {
        $config = self::getConfig();

        $urlBuilder = new UrlBuilder(
            $config['domain'],
            $config['placeholderUrl'],
            $config['queryParameters']
        );

        return $urlBuilder;
    }

    private static function createResponseTransformer(UrlBuilder $urlBuilder): ResponseTransformer
    {
        return ResponseTransformerFactory::create($urlBuilder);
    }

    public static function create(): Linguee
    {
        $urlBuilder = self::createUrlBuilder();
        $linguee = new Linguee(
            $urlBuilder,
            self::createResponseTransformer($urlBuilder),
            self::createClient(),
            self::getLanguageConfig()
        );

        return $linguee;
    }
}
