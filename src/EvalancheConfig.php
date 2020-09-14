<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use Scn\EvalancheReportingApiConnector\Enum\Language;
use Scn\EvalancheReportingApiConnector\Enum\TimeFormat;

final class EvalancheConfig implements EvalancheConfigInterface
{
    private string $hostname;
    private string $username;
    private string $password;
    private string $language;
    private string $timeFormat;

    public function __construct(
        string $hostname,
        string $username,
        string $password,
        string $language,
        string $timeFormat
    ) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->language = $language;
        $this->timeFormat = $timeFormat;
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
        if (in_array($this->language, Language::ALLOWED_LANGUAGES)) {
            return $this->language;
        }
        return Language::LANG_EN;
    }

    public function getTimeFormat(): string
    {
        if (in_array($this->timeFormat, TimeFormat::ALLOWED_FORMATS)) {
            return $this->timeFormat;
        }
        return TimeFormat::ISO8601;
    }
}
