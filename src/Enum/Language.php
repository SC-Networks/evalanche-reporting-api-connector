<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Enum;

final class Language
{
    public const string LANG_EN = 'en';
    public const string LANG_DE = 'de';
    public const string LANG_IT = 'it';
    public const string LANG_FR = 'fr';

    public const array ALLOWED_LANGUAGES  = [
        self::LANG_EN,
        self::LANG_DE,
        self::LANG_IT,
        self::LANG_FR,
    ];
}
