<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Enum;

final class TimeFormat
{
    public const ISO8601 = 'iso8601';
    public const UNIX = 'unix';
    public const RFC822 = 'rfc822';
    public const RFC850 = 'rfc850';
    public const RFC1036 = 'rfc1036';
    public const RFC1123 = 'rfc1123';
    public const RFC2822 = 'rfc2822';
    public const RFC3339 = 'rfc3339';
    public const W3C = 'w3c';

    public const ALLOWED_FORMATS = [
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
