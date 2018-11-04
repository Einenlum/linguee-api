<?php

namespace spec\Einenlum\LingueeApi\Query;

use Einenlum\LingueeApi\Query\UrlBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlBuilderSpec extends ObjectBehavior
{
    const DOMAIN = 'http://domain.com';
    const PLACEHOLDER_URL = '/some-search/{from}/{to}/lorem';
    const QUERY_PARAMETERS = [
        'some' => 'thing',
        'encoded' => 'ąéîïęĵłяз',
        'query' => ''
    ];

    public function let()
    {
        $this->beConstructedWith(
            self::DOMAIN,
            self::PLACEHOLDER_URL,
            self::QUERY_PARAMETERS
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UrlBuilder::class);
    }

    function it_returns_a_well_formatted_url()
    {
        $this
            ->build('cake', 'english', 'turkish')
            ->shouldReturn(
                'http://domain.com/some-search/english/turkish/lorem?some=thing&encoded=%C4%85%C3%A9%C3%AE%C3%AF%C4%99%C4%B5%C5%82%D1%8F%D0%B7&query=cake'
            );

        $this
            ->build('sache', 'german', 'french')
            ->shouldReturn(
                'http://domain.com/some-search/german/french/lorem?some=thing&encoded=%C4%85%C3%A9%C3%AE%C3%AF%C4%99%C4%B5%C5%82%D1%8F%D0%B7&query=sache'
            );
    }

    function it_returns_a_well_formatted_audio_url()
    {
        $this
            ->buildAudio('some-audio-path.mp3')
            ->shouldReturn(
                'http://domain.com/mp3/some-audio-path.mp3'
            );

        $this
            ->buildAudio('/some-audio-path.mp3')
            ->shouldReturn(
                'http://domain.com/mp3/some-audio-path.mp3'
            );
    }
}
