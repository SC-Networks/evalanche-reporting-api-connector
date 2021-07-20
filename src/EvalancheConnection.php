<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\Client;

final class EvalancheConnection implements EvalancheConnectionInterface
{
    public function __construct(
        private RequestFactoryInterface $requestFactory,
        private ClientInterface $httpClient,
        private EvalancheConfigInterface $config
    ) {
    }

    public function getCustomers(): Client\ClientInterface
    {
        return new Client\CustomersClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getForms(): Client\ClientInterface
    {
        return new Client\FormsClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getLeadpages(int $customerId = null): Client\ClientInterface
    {
        return new Client\LeadpagesClient($customerId, $this->requestFactory, $this->httpClient, $this->config);
    }

    public function getMailings(): Client\ClientInterface
    {
        return new Client\MailingsClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getPools(): Client\ClientInterface
    {
        return new Client\PoolsClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getProfileChangelogs(int $poolId): Client\ClientInterface
    {
        return new Client\ProfileChangelogsClient($poolId, $this->requestFactory, $this->httpClient, $this->config);
    }

    public function getProfiles(int $poolId): Client\ClientInterface
    {
        return new Client\ProfilesClient($poolId, $this->requestFactory, $this->httpClient, $this->config);
    }

    public function getProfileScores(): Client\ClientInterface
    {
        return new Client\ProfileScoresClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getResourceTypes(): Client\ClientInterface
    {
        return new Client\ResourceTypesClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getScoringGroups(): Client\ClientInterface
    {
        return new Client\ScoringGroupsClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getScoringHistory(): Client\ClientInterface
    {
        return new Client\ScoringHistoryClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getTrackingHistory(): Client\ClientInterface
    {
        return new Client\TrackingHistoryClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getTrackingTypes(): Client\ClientInterface
    {
        return new Client\TrackingTypesClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getNewsletterSendlogs(int $customerId): Client\ClientInterface
    {
        return new Client\NewsletterSendlogsClient($customerId, $this->requestFactory, $this->httpClient, $this->config);
    }

    public function getMilestoneProfiles(int $customerId): Client\ClientInterface
    {
        return new Client\MilestoneProfileClient($customerId, $this->requestFactory, $this->httpClient, $this->config);
    }

    public function getCampaignProfileHistory(int $campaignId): Client\ClientInterface
    {
        return new Client\CampaignProfileHistoryClient(
            $campaignId,
            $this->requestFactory,
            $this->httpClient,
            $this->config
        );
    }
}
