# Linguee API

Ask linguee anything. Heavily inspired by this [JS project](https://github.com/felipe-augusto/linguee).
Linguee has no API. This is a PHP library to send an HTTP request to Linguee and fetch the response (it populates a `Einenlum\LingueeApi\Response\DTO\Response` object and can be serialized to JSON).

## Install

`composer require einenlum/linguee-api`

## Usage

```php
<?php
use Einenlum\LingueeApi\Factory;

$linguee = Factory::create();

// Example: https://www.linguee.com/english-german/search?query=desert
$response = $linguee->translate('desert', 'eng', 'ger');

// $response is an instance of Einenlum\LingueeApi\Response\DTO\Response
echo $response->toJson();
/**
Prints:

{
  "query": "desert",
  "words": [
    {
      "term": "desert",
      "additionalInformation": null,
      "type": "noun",
      "audio":
        "https://www.linguee.com/mp3/EN_US/3f/3fd6b6210e33bb046e69f256a138e28d-101",
      "translations": [
        {
          "term": "W\u00fcste",
          "audio":
            "https://www.linguee.com/mp3/DE/c4/c4e37c83329756bbd9c02791bd76199d-104",
          "type": "f",
          "alternatives": [],
          "examples": [
            {
              "from": "In the desert, water is a scarce resource.",
              "to": "In der W\u00fcste ist Wasser eine knappe Ressource."
            },
            {
              "from": "The desert is arid with sparse vegetation.",
              "to": "Die W\u00fcste ist trocken mit karger Vegetation."
            }
          ]
        }
      ]
    },
    {
      "term": "desert",
      "additionalInformation": null,
      "type": "adjective",
      "audio":
        "https://www.linguee.com/mp3/EN_US/3f/3fd6b6210e33bb046e69f256a138e28d-300",
      "translations": [
        {
          "term": "w\u00fcst",
          "audio":
            "https://www.linguee.com/mp3/DE/1c/1cb563d1405f4092dd6abc05456ca5b9-300",
          "type": "adj",
          "alternatives": [],
          "examples": []
        }
      ]
    },
    {
      "term": "desert",
      "additionalInformation": null,
      "type": "verb",
      "audio":
        "https://www.linguee.com/mp3/EN_US/3f/3fd6b6210e33bb046e69f256a138e28d-200",
      "translations": [
        {
          "term": "desertieren",
          "audio":
            "https://www.linguee.com/mp3/DE/c3/c39c3bdec7b4b5bd85fcb745a2798347-202",
          "type": "v",
          "alternatives": [],
          "examples": [
            {
              "from": "The soldiers deserted as defeat became inevitable.",
              "to":
                "Die Soldaten desertierten, als eine Niederlage unausweichlich wurde."
            }
          ]
        }
      ]
    }
  ],
  "examples": [
    {
      "from": {"content": "Mojave Desert", "type": "n", "audio": null},
      "tos": [{"content": "Mojave-W\u00fcste", "type": "f"}]
    },
    {
      "from": {"content": "desert dunes", "type": "pl", "audio": null},
      "tos": [{"content": "W\u00fcstend\u00fcnen", "type": "pl"}]
    },
    {
      "from": {"content": "desert conditions", "type": "pl", "audio": null},
      "tos": [{"content": "W\u00fcstenbedingungen", "type": "pl"}]
    },
    {
      "from": {"content": "coastal desert", "type": "n", "audio": null},
      "tos": [{"content": "K\u00fcstenw\u00fcste", "type": "f"}]
    },
    {
      "from": {"content": "desert terrain", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenterrain", "type": "nt"}]
    },
    {
      "from": {"content": "desert heat", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenhitze", "type": "f"}]
    },
    {
      "from": {"content": "desert country", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenstaat", "type": "m"}]
    },
    {
      "from": {"content": "Arabian desert", "type": "n", "audio": null},
      "tos": [{"content": "arabische W\u00fcste", "type": "f"}]
    },
    {
      "from": {"content": "desert areas", "type": "pl", "audio": null},
      "tos": [{"content": "W\u00fcstengebiete", "type": "pl"}]
    },
    {
      "from": {"content": "desert lynx", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenluchs", "type": "m"}]
    },
    {
      "from": {"content": "desert coast", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenk\u00fcste", "type": "f"}]
    },
    {
      "from": {"content": "red desert", "type": "n", "audio": null},
      "tos": [{"content": "rote W\u00fcste", "type": "f"}]
    },
    {
      "from": {"content": "strip of desert", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenstreifen", "type": "m"}]
    },
    {
      "from": {"content": "desert ground", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenboden", "type": "m"}]
    },
    {
      "from": {
        "content": "desert to the enemy",
        "type": "v",
        "audio":
          "https://www.linguee.com/mp3/EN_UK/a2/a2f1c88946632af7e4715e87f492d66f-200"
      },
      "tos": [{"content": "zum Feind \u00fcberlaufen", "type": "v"}]
    },
    {
      "from": {"content": "desert from the army", "type": "v", "audio": null},
      "tos": [{"content": "von der Armee desertieren", "type": "v"}]
    },
    {
      "from": {"content": "desert surface", "type": "n", "audio": null},
      "tos": [
        {"content": "W\u00fcstenboden", "type": "m"},
        {"content": "W\u00fcstenfl\u00e4che", "type": "f"}
      ]
    },
    {
      "from": {"content": "desert plant", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenpflanze", "type": "f"}]
    },
    {
      "from": {"content": "desert foxes", "type": "pl", "audio": null},
      "tos": [{"content": "W\u00fcstenf\u00fcchse", "type": "pl"}]
    },
    {
      "from": {"content": "desert animals", "type": "pl", "audio": null},
      "tos": [{"content": "W\u00fcstentiere", "type": "pl"}]
    },
    {
      "from": {"content": "desert sun", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstensonne", "type": "f"}]
    },
    {
      "from": {"content": "desert race", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenrennen", "type": "nt"}]
    },
    {
      "from": {"content": "flowering desert", "type": "n", "audio": null},
      "tos": [{"content": "bl\u00fchende W\u00fcste", "type": "f"}]
    },
    {
      "from": {"content": "desert wind", "type": "n", "audio": null},
      "tos": [{"content": "W\u00fcstenwind", "type": "m"}]
    },
    {
      "from": {"content": "blooming desert", "type": "n", "audio": null},
      "tos": [{"content": "bl\u00fchende W\u00fcste", "type": "f"}]
    },
    {
      "from": {"content": "desert adventures", "type": "pl", "audio": null},
      "tos": [{"content": "W\u00fcstenausfl\u00fcge", "type": "pl"}]
    },
    {
      "from": {"content": "desert formations", "type": "pl", "audio": null},
      "tos": [{"content": "W\u00fcstenbildungen", "type": "pl"}]
    },
    {
      "from": {"content": "huge desert", "type": "n", "audio": null},
      "tos": [{"content": "gro\u00dfe W\u00fcste", "type": "f"}]
    },
    {
      "from": {"content": "emotional desert", "type": "n", "audio": null},
      "tos": [{"content": "emotionale W\u00fcste", "type": "f"}]
    }
  ]
}
*/
```

## Configuration

Available languages:

- 'eng' : english
- 'ger' : german
- 'fra' : french
- 'spa' : spanish
- 'chi' : chinese
- 'rus' : russian
- 'jpn' : japanese
- 'por' : portuguese
- 'ita' : italian
- 'dut' : dutch
- 'pol' : polish
- 'swe' : swedish
- 'dan' : danish
- 'fin' : finnish
- 'gre' : greek
- 'cze' : czech
- 'rum' : romanian
- 'hun' : hungarian
- 'slo' : slovak
- 'bul' : bulgarian
- 'slv' : slovene
- 'lit' : lithuanian
- 'lav' : latvian
- 'est' : estonian
- 'mlt' : maltese

## Tests

Tested thanks to PHPStan, PHPSpec and PHPUnit.
To launch the tests:

`composer test`

## Coding Standards

Coding Standards are checked and fixed thanks to PHP-CS-Fixer. To fix your code, just run composer cs-fix.

## Contributing

Please, feel free to contribute and improve this project.

## License

MIT

Please respect Linguee's [terms and conditions](https://www.linguee.com/english-french/page/termsAndConditions.php).
