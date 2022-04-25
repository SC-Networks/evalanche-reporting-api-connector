<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\Client;

/**
 * Provides factory methods for the creation of the table-based client classes
 */
final class EvalancheConnection implements EvalancheConnectionInterface
{
    public function __construct(
        private RequestFactoryInterface $requestFactory,
        private ClientInterface $httpClient,
        private EvalancheConfigInterface $config
    ) {
    }

    /**
     * Queries the `customers` table
     */
    public function getCustomers(): Client\ClientInterface
    {
        return new Client\CustomersClient($this->requestFactory, $this->httpClient, $this->config);
    }

    /**
     * Queries the `forms` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getForms(int $customerId = null): Client\ClientInterface
    {
        return new Client\FormsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId
        );
    }

    /**
     * Queries the `leadpages` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getLeadpages(int $customerId = null): Client\ClientInterface
    {
        return new Client\LeadpagesClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    /**
     * Queries the `mailings` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
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

    /**
     * Queries the `pools` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
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

    /**
     * Queries the `profilechangelogs` table
     *
     * @param int $poolId Id of the pool whose profiles should be used
     */
    public function getProfileChangelogs(int $poolId): Client\ClientInterface
    {
        return new Client\ProfileChangelogsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $poolId,
        );
    }

    /**
     * Queries the `profiles` table
     *
     * @param int $poolId Id of the pool whose profiles should be used
     */
    public function getProfiles(int $poolId): Client\ClientInterface
    {
        return new Client\ProfilesClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $poolId,
        );
    }

    /**
     * Queries the `profilescores` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
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

    /**
     * Queries the `resourcetypes` table
     */
    public function getResourceTypes(): Client\ClientInterface
    {
        return new Client\ResourceTypesClient($this->requestFactory, $this->httpClient, $this->config);
    }

    /**
     * Queries the `scoringgroups` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
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

    /**
     * Queries the `scoringhistory` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
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

    /**
     * Queries the `trackinghistory` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
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

    /**
     * Queries the `trackingtypes` table
     */
    public function getTrackingTypes(): Client\ClientInterface
    {
        return new Client\TrackingTypesClient($this->requestFactory, $this->httpClient, $this->config);
    }

    /**
     * Queries the `newslettersendlogs` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getNewsletterSendlogs(int $customerId): Client\ClientInterface
    {
        return new Client\NewsletterSendlogsClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    /**
     * Queries the `milestone-profiles` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getMilestoneProfiles(int $customerId): Client\ClientInterface
    {
        return new Client\MilestoneProfileClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    /**
     * Queries the `campaign-profile-history` table
     *
     * @param int $campaignId Id of the campaign whose history should be retrieved
     */
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
