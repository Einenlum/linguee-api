<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Tests\Response;

use Einenlum\LingueeApi\Response\Transformer;
use PHPUnit\Framework\TestCase;
use Einenlum\LingueeApi\Factory\ResponseTransformer as ResponseTransformerFactory;
use Einenlum\LingueeApi\Query\UrlBuilder;

class TransformerTest extends TestCase
{
    private Transformer $responseTransformer;

    public function setUp(): void
    {
        $urlBuilder = new UrlBuilder(
            'https://www.linguee.com',
            'auie',
            []
        );
        $this->responseTransformer = ResponseTransformerFactory::create($urlBuilder);
    }

    /** @dataProvider getCases */
    public function test(string $path, string $query)
    {
        $input = $this->getInput($path);
        $expected = $this->getExpected($path);
        $output = $this->responseTransformer->transform($input, $query);

        $expectedArray = json_decode($expected, true);
        $outputArray = $output->toArray();

        $this->assertEquals($expectedArray, $outputArray);
    }

    public function getCases(): array
    {
        return [
            'Money - English to French' => ['money-eng-fra', 'money'],
            'Desert - English to Russian' => ['desert-eng-rus', 'desert'],
            '历 - Chinese to English' => ['history-chi-eng', '历'],
            'Vernachlässigen - German to English' => ['vernachlassigen-ger-eng', 'vernachlässigen'],
        ];
    }

    private function getExampleDir($path): string
    {
        return sprintf('%s/../examples/%s', __DIR__, $path);
    }

    private function getInput(string $path): string
    {
        return file_get_contents(sprintf(
            '%s/input.html',
            $this->getExampleDir($path)
        ));
    }

    private function getExpected(string $path): string
    {
        return file_get_contents(sprintf(
            '%s/expected.json',
            $this->getExampleDir($path)
        ));
    }
}
