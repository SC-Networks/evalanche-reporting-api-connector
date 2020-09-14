<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use PHPUnit\Framework\TestCase;
use Scn\EvalancheReportingApiConnector\Enum\Language;
use Scn\EvalancheReportingApiConnector\Enum\TimeFormat;

class EvalancheConfigTest extends TestCase
{
    private EvalancheConfig $subject;
    
    private string $hostname = 'my-host';
    
    private string $username = 'my-user';
    
    private string $password = 'my-password';
    
    private string $language = Language::LANG_IT;
    
    private string $timeFormat = TimeFormat::RFC1123;


    public function setUp(): void
    {
        $this->subject = new EvalancheConfig(
            $this->hostname,
            $this->username,
            $this->password,
            $this->language,
            $this->timeFormat
        );
    }

    public function testGetUsernameReturnsString(): void
    {
        $this->assertSame(
            $this->username,
            $this->subject->getUsername()
        );
    }

    public function testGetHostnameReturnsString(): void
    {
        $this->assertSame(
            $this->hostname,
            $this->subject->getHostname()
        );
    }

    public function testGetPasswordReturnsString(): void
    {
        $this->assertSame(
            $this->password,
            $this->subject->getPassword()
        );
    }

    public function testGetLanguageReturnsString(): void
    {
        $this->assertSame(
            $this->language,
            $this->subject->getLanguage()
        );
    }

    public function testGetLanguageReturnsDefaultString(): void
    {
        $this->subject = new EvalancheConfig(
            $this->hostname,
            $this->username,
            $this->password,
            'my-fancy-language',
            $this->timeFormat
        );

        $this->assertSame(
            Language::LANG_EN,
            $this->subject->getLanguage()
        );
    }

    public function testGetTimeFormatReturnsString(): void
    {
        $this->assertSame(
            $this->timeFormat,
            $this->subject->getTimeFormat()
        );
    }

    public function testGetTimeFormatReturnsDefaultString(): void
    {
        $this->subject = new EvalancheConfig(
            $this->hostname,
            $this->username,
            $this->password,
            $this->language,
            'my-fancy-time-format'
        );

        $this->assertSame(
            TimeFormat::ISO8601,
            $this->subject->getTimeFormat()
        );
    }
}
