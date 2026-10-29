<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Enum;

final class TimeFormat
{
    public const string ISO8601 = 'iso8601';
    public const string UNIX = 'unix';
    public const string RFC822 = 'rfc822';
    public const string RFC850 = 'rfc850';
    public const string RFC1036 = 'rfc1036';
    public const string RFC1123 = 'rfc1123';
    public const string RFC2822 = 'rfc2822';
    public const string RFC3339 = 'rfc3339';
    public const string W3C = 'w3c';

    public const array ALLOWED_FORMATS = [
        self::ISO8601,
        self::UNIX,
        self::RFC822,
        self::RFC850,
        self::RFC1036,
        self::RFC1123,
        self::RFC2822,
        self::RFC3339,
        self::W3C,
    ];
}
