<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\Enum\Format;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;
use stdClass;

abstract class AbstractClient implements ClientInterface
{
    private ?string $fromDateTime = null;

    private ?string $toDateTime = null;

    public function __construct(
        private RequestFactoryInterface $requestFactory,
        private \Psr\Http\Client\ClientInterface $httpClient,
        protected EvalancheConfigInterface $evalancheConfig
    ) {
    }

    protected function isRestrictable(): bool
    {
        return false;
    }

    public function withTimeRestriction(?string $from = null, ?string $to = null): ClientInterface
    {
        $this->fromDateTime = $from;
        $this->toDateTime = $to;
        return $this;
    }

    public function asJsonArray(): array
    {
        return json_decode($this->get(Format::JSON_ARRAY)) ?? [];
    }

    public function asJsonObject(): stdClass
    {
        return json_decode($this->get(Format::JSON_OBJECT)) ?? new stdClass();
    }

    public function asXml(): string
    {
        return $this->get(Format::XML);
    }

    public function asCsv(): string
    {
        return $this->get(Format::CSV);
    }

    abstract protected function getTableName(): string;

    /**
     * @return array<string, mixed>
     */
    protected function getAdditionalParam(): array
    {
        return [];
    }

    /**
     * @throws ClientExceptionInterface
     * @throws NetworkExceptionInterface
     */
    private function get(string $format): string
    {
        $request = $this->requestFactory->createRequest(
            'GET',
            sprintf(
                'https://%s/report.php?%s',
                $this->evalancheConfig->getHostname(),
                http_build_query($this->aggregateQueryParams($format))
            )
        );

        return $this->httpClient->sendRequest($request)->getBody()->getContents();
    }

    /**
     * @return array<string, mixed>
     */
    private function aggregateQueryParams(string $format): array
    {
        $urlParameters = [
            'table' => $this->getTableName(),
            'format' => $format,
            'time_format' => $this->evalancheConfig->getTimeFormat(),
            'lang' => $this->evalancheConfig->getLanguage(),
        ];

        if ($this->isRestrictable() === true) {
            if ($this->fromDateTime !== null) {
                $urlParameters['from'] = urlencode($this->fromDateTime);
            }
            if ($this->toDateTime !== null) {
                $urlParameters['to'] = urlencode($this->toDateTime);
            }
        }

        return array_merge($urlParameters, $this->getAdditionalParam());
    }
}
