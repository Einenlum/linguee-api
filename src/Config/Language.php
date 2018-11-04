<?php

declare(strict_types=1);

namespace Einenlum\LingueeApi\Config;

class Language
{
    private $languages;

    public function __construct(array $languages)
    {
        $this->languages = $languages;
    }

    public function getLanguage(string $languageId): string
    {
        foreach ($this->languages as $id => $language) {
            if ($id === $languageId) {
                return $language;
            }
        }

        throw new \Exception(sprintf(
            'No language was found with id %s',
            $languageId
        ));
    }
}
