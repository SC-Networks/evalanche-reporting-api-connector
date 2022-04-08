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

    public function getForms(int $customerId = null): Client\ClientInterface
    {
        return new Client\FormsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId
        );
    }

    public function getLeadpages(int $customerId = null): Client\ClientInterface
    {
        return new Client\LeadpagesClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getMailings(
        int $customerId = null
    ): Client\ClientInterface {
        return new Client\MailingsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getPools(
        int $customerId = null
    ): Client\ClientInterface {
        return new Client\PoolsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getProfileChangelogs(int $poolId): Client\ClientInterface
    {
        return new Client\ProfileChangelogsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $poolId,
        );
    }

    public function getProfiles(int $poolId): Client\ClientInterface
    {
        return new Client\ProfilesClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $poolId,
        );
    }

    public function getProfileScores(
        int $customerId = null
    ): Client\ClientInterface {
        return new Client\ProfileScoresClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getResourceTypes(): Client\ClientInterface
    {
        return new Client\ResourceTypesClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getScoringGroups(
        int $customerId = null
    ): Client\ClientInterface {
        return new Client\ScoringGroupsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getScoringHistory(
        int $customerId = null
    ): Client\ClientInterface {
        return new Client\ScoringHistoryClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getTrackingHistory(
        int $customerId = null
    ): Client\ClientInterface {
        return new Client\TrackingHistoryClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getTrackingTypes(): Client\ClientInterface
    {
        return new Client\TrackingTypesClient($this->requestFactory, $this->httpClient, $this->config);
    }

    public function getNewsletterSendlogs(int $customerId): Client\ClientInterface
    {
        return new Client\NewsletterSendlogsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getMilestoneProfiles(int $customerId): Client\ClientInterface
    {
        return new Client\MilestoneProfileClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    public function getCampaignProfileHistory(int $campaignId): Client\ClientInterface
    {
        return new Client\CampaignProfileHistoryClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $campaignId,
        );
    }
}
