<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Enum;

final class Language
{
    public const LANG_EN = 'en';
    public const LANG_DE = 'de';
    public const LANG_IT = 'it';
    public const LANG_FR = 'fr';

    public const ALLOWED_LANGUAGES  = [
        self::LANG_EN,
        self::LANG_DE,
        self::LANG_IT,
        self::LANG_FR,
    ];
}
