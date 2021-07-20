<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use Scn\EvalancheReportingApiConnector\Enum\Language;
use Scn\EvalancheReportingApiConnector\Enum\TimeFormat;

final class EvalancheConfig implements EvalancheConfigInterface
{
    public function __construct(
        private string $hostname,
        private string $username,
        private string $password,
        private string $language,
        private string $timeFormat
    ) {
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getLanguage(): string
    {
        if (in_array($this->language, Language::ALLOWED_LANGUAGES, true)) {
            return $this->language;
        }
        return Language::LANG_EN;
    }

    public function getTimeFormat(): string
    {
        if (in_array($this->timeFormat, TimeFormat::ALLOWED_FORMATS, true)) {
            return $this->timeFormat;
        }
        return TimeFormat::ISO8601;
    }
}
