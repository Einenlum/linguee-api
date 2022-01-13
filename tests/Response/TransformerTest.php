<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Tests\Response;

use PHPUnit\Framework\TestCase;
use Einenlum\LingueeApi\Factory\ResponseTransformer as ResponseTransformerFactory;
use Einenlum\LingueeApi\Query\UrlBuilder;

class TransformerTest extends TestCase
{
    private $responseTransformer;
    private $tests = [
        ['path' => 'money-eng-fra', 'query' => 'money'],
        ['path' => 'desert-eng-rus', 'query' => 'desert'],
        ['path' => 'history-chi-eng', 'query' => '历']
    ];

    private function getExampleDir($path): string
    {
        return sprintf('%s/../examples/%s', __DIR__, $path);
    }

    private function getInput(string $path)
    {
        $encodeToUtf8 = function ($string) {
            return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
        };

        return $encodeToUtf8(file_get_contents(sprintf(
            '%s/input.html',
            $this->getExampleDir($path)
        )));
    }

    private function getExpected(string $path)
    {
        return file_get_contents(sprintf(
            '%s/expected.json',
            $this->getExampleDir($path)
        ));
    }

    public function setUp(): void
    {
        $urlBuilder = new UrlBuilder(
            'https://www.linguee.com',
            'auie',
            []
        );
        $this->responseTransformer = ResponseTransformerFactory::create($urlBuilder);
    }

    public function test()
    {
        foreach ($this->tests as $line) {
            $input = $this->getInput($line['path']);
            $expected = $this->getExpected($line['path']);
            $output = $this->responseTransformer->transform($input, $line['query']);

            $expectedArray = json_decode($expected, true);
            $outputArray = $output->toArray();

            $this->assertEquals($expectedArray, $outputArray);
        }
    }
}
