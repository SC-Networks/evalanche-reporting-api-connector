<?php

namespace Scn\EvalancheReportingApiConnector;

interface EvalancheConfigInterface
{
    public function getHostname(): string;

    public function getUsername(): string;

    public function getPassword(): string;

    public function getLanguage(): string;

    public function getTimeFormat(): string;
}
