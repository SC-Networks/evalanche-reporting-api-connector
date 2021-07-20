<?php

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\NetworkExceptionInterface;

interface ClientInterface
{
    /**
     * @return array<mixed>
     *
     * @throws ClientExceptionInterface
     * @throws NetworkExceptionInterface
     */
    public function asJsonArray(): array;

    /**
     * @throws ClientExceptionInterface
     * @throws NetworkExceptionInterface
     */
    public function asJsonObject(): \stdClass;

    /**
     * @throws ClientExceptionInterface
     * @throws NetworkExceptionInterface
     */
    public function asXml(): string;

    /**
     * @throws ClientExceptionInterface
     * @throws NetworkExceptionInterface
     */
    public function asCsv(): string;

    public function withTimeRestriction(?string $from = null, ?string $to = null): ClientInterface;
}
