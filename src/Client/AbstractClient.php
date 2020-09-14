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
    private RequestFactoryInterface $requestFactory;

    private \Psr\Http\Client\ClientInterface $httpClient;

    protected EvalancheConfigInterface $evalancheConfig;

    /**
     * @var string
     */
    private $fromDateTime;

    /**
     * @var string
     */
    private $toDateTime;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $httpClient,
        EvalancheConfigInterface $evalancheConfig
    ) {
        $this->requestFactory = $requestFactory;
        $this->httpClient = $httpClient;
        $this->evalancheConfig = $evalancheConfig;
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

    protected abstract function getTableName(): string;

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

    private function aggregateQueryParams(string $format): array
    {
        $urlParameters = [
            'table' => $this->getTableName(),
            'format' => $format,
            'time_format' => $this->evalancheConfig->getTimeFormat(),
            'lang' => $this->evalancheConfig->getLanguage(),
        ];

        if (true === $this->isRestrictable()) {
            if (null !== $this->fromDateTime) {
                $urlParameters['from'] = urlencode($this->fromDateTime);
            }
            if (null !== $this->toDateTime) {
                $urlParameters['to'] = urlencode($this->toDateTime);
            }
        }

        return array_merge($urlParameters, $this->getAdditionalParam());
    }
}
