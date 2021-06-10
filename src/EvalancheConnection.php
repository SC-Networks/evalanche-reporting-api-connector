<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use GuzzleHttp\Client as GuzzleClient;
use Scn\EvalancheReportingApiConnector\Client;
use Scn\EvalancheReportingApiConnector\Enum\Language;
use Scn\EvalancheReportingApiConnector\Enum\TimeFormat;

final class EvalancheConnection
{
    private $config;
    private $httpClient;

    public function __construct(
        EvalancheConfigInterface $config,
        GuzzleClient $http_client
    ) {
        $this->config = $config;
        $this->httpClient = $http_client;
    }

    public static function create(
        string $hostname,
        string $username,
        string $password,
        string $language = Language::LANG_EN,
        string $timeFormat = TimeFormat::ISO8601,
        bool $debugMode = false
    ): EvalancheConnection {
        $clientConfig = [
            'base_uri' => sprintf('https://%s', $hostname),
            'auth' => [
                $username,
                $password,
            ],
            'verify' => !$debugMode,
        ];

        return new EvalancheConnection(
            new EvalancheConfig(
                $hostname,
                $username,
                $password,
                $language,
                $timeFormat
            ),
            new GuzzleClient($clientConfig)
        );
    }

    /**
     * @deprecated Checkpoint object has been removed
     */
    public function getCheckpoints(int $customerId = null): Client\ClientInterface
    {
        return new Client\CheckpointsClient($customerId, $this->httpClient, $this->config);
    }

    /**
     * @deprecated Checkpoint object has been removed
     */
    public function getCheckpointStatistics(): Client\ClientInterface
    {
        return $this->createClient(Client\CheckpointStatisticsClient::class);
    }

    public function getCustomers(): Client\ClientInterface
    {
        return $this->createClient(Client\CustomersClient::class);
    }

    public function getForms(): Client\ClientInterface
    {
        return $this->createClient(Client\FormsClient::class);
    }

    public function getLeadpages(int $customerId = null): Client\ClientInterface
    {
        return new Client\LeadpagesClient($customerId, $this->httpClient, $this->config);
    }

    public function getMailings(): Client\ClientInterface
    {
        return $this->createClient(Client\MailingsClient::class);
    }

    public function getPools(): Client\ClientInterface
    {
        return $this->createClient(Client\PoolsClient::class);
    }

    public function getProfileChangelogs(int $pool_id): Client\ClientInterface
    {
        return new Client\ProfileChangelogsClient($pool_id, $this->httpClient, $this->config);
    }

    public function getProfiles(int $pool_id): Client\ClientInterface
    {
        return new Client\ProfilesClient($pool_id, $this->httpClient, $this->config);
    }

    public function getProfileScores(): Client\ClientInterface
    {
        return $this->createClient(Client\ProfileScoresClient::class);
    }

    public function getResourceTypes(): Client\ClientInterface
    {
        return $this->createClient(Client\ResourceTypesClient::class);
    }

    public function getScoringGroups(): Client\ClientInterface
    {
        return $this->createClient(Client\ScoringGroupsClient::class);
    }

    public function getScoringHistory(): Client\ClientInterface
    {
        return $this->createClient(Client\ScoringHistoryClient::class);
    }

    public function getTrackingHistory(): Client\ClientInterface
    {
        return $this->createClient(Client\TrackingHistoryClient::class);
    }

    public function getTrackingTypes(): Client\ClientInterface
    {
        return $this->createClient(Client\TrackingTypesClient::class);
    }

    public function getNewsletterSendlogs(int $customer_id): Client\ClientInterface
    {
        return new Client\NewsletterSendlogsClient($customer_id, $this->httpClient, $this->config);
    }

    public function getMilestoneProfiles(int $customerId): Client\ClientInterface
    {
        return new Client\MilestoneProfileClient($customerId, $this->httpClient, $this->config);
    }

    private function createClient(string $clientClass): Client\ClientInterface
    {
        return new $clientClass($this->httpClient, $this->config);
    }
}
