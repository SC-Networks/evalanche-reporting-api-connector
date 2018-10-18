<?php declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use GuzzleHttp\Exception\ConnectException;
use Scn\EvalancheReportingApiConnector\Enum\Format;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;
use Scn\EvalancheReportingApiConnector\Exception;
use Teapot\StatusCode;

abstract class AbstractClient implements ClientInterface
{
    protected $evalancheConfig;
    private $httpClient;

    /**
     * @var string
     */
    private $fromDateTime;
    /**
     * @var string
     */
    private $toDateTime;

    public function __construct(
        \GuzzleHttp\Client $http_client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        $this->evalancheConfig = $evalancheConfig;
        $this->httpClient = $http_client;
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

    public function asJsonObject(): \stdClass
    {
        return json_decode($this->get(Format::JSON_OBJECT)) ?? new \stdClass();
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

    private function get(string $format): string
    {
        try {
            return $this->httpClient
                ->request(
                    'GET',
                    'report.php',
                    ['query' => $this->aggregateQueryParams($format)]
                )
                ->getBody()
                ->getContents();
        } catch (ConnectException $e) {
            throw new Exception\ConnectionException($e->getMessage());
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case StatusCode::BAD_REQUEST:
                    throw new Exception\InvalidParamException($e->getMessage());
                case StatusCode::UNAUTHORIZED:
                    throw new Exception\AuthorizationException($e->getMessage());
                case StatusCode::NOT_FOUND:
                    throw new Exception\UnreachableEndpointException($e->getMessage());
                default:
                    throw $e;
            }
        }
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
