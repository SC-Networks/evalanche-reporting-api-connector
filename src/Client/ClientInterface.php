<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

interface ClientInterface
{
    public function asJsonArray(): array;

    public function asJsonObject(): \stdClass;

    public function asXml(): string;

    public function asCsv(): string;

    public function withTimeRestriction(?string $from = null, ?string $to = null): ClientInterface;
}
