<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Http;

use Buzz\Browser;
use Einenlum\LingueeApi\Contract\Http\Client as ClientInterface;

class Client implements ClientInterface
{
    private $browser;

    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    public function send(string $url): string
    {
        $response = $this->browser->get($url);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200 && $statusCode !== 301) {
            throw new \Exception(sprintf(
                'Response with status code %d',
                $statusCode
            ));
        }

        return $response->getBody()->getContents();
    }
}
