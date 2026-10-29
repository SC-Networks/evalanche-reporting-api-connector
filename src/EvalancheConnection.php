<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use Scn\EvalancheReportingApiConnector\Client\CustomersClient;
use Scn\EvalancheReportingApiConnector\Client\FormsClient;
use Scn\EvalancheReportingApiConnector\Client\LeadpagesClient;
use Scn\EvalancheReportingApiConnector\Client\MailingsClient;
use Scn\EvalancheReportingApiConnector\Client\PoolsClient;
use Scn\EvalancheReportingApiConnector\Client\ProfileChangelogsClient;
use Scn\EvalancheReportingApiConnector\Client\ProfilesClient;
use Scn\EvalancheReportingApiConnector\Client\ProfileScoresClient;
use Scn\EvalancheReportingApiConnector\Client\ResourceTypesClient;
use Scn\EvalancheReportingApiConnector\Client\ScoringGroupsClient;
use Scn\EvalancheReportingApiConnector\Client\ScoringHistoryClient;
use Scn\EvalancheReportingApiConnector\Client\TrackingHistoryClient;
use Scn\EvalancheReportingApiConnector\Client\TrackingTypesClient;
use Scn\EvalancheReportingApiConnector\Client\NewsletterSendlogsClient;
use Scn\EvalancheReportingApiConnector\Client\MilestoneProfileClient;
use Scn\EvalancheReportingApiConnector\Client\CampaignProfileHistoryClient;
use Scn\EvalancheReportingApiConnector\Client\ScoringClusterClient;
use Scn\EvalancheReportingApiConnector\Client\GeoCoordinatesClient;
use Scn\EvalancheReportingApiConnector\Client\ArticleReferencesClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\Client;

/**
 * Provides factory methods for the creation of the table-based client classes
 */
final readonly class EvalancheConnection implements EvalancheConnectionInterface
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
        return new CustomersClient($this->requestFactory, $this->httpClient, $this->config);
    }

    /**
     * Queries the `forms` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getForms(?int $customerId = null): Client\ClientInterface
    {
        return new FormsClient(
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
    public function getLeadpages(?int $customerId = null): Client\ClientInterface
    {
        return new LeadpagesClient(
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
        ?int $customerId = null
    ): Client\ClientInterface {
        return new MailingsClient(
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
        ?int $customerId = null
    ): Client\ClientInterface {
        return new PoolsClient(
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
        return new ProfileChangelogsClient(
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
        return new ProfilesClient(
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
        ?int $customerId = null
    ): Client\ClientInterface {
        return new ProfileScoresClient(
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
        return new ResourceTypesClient($this->requestFactory, $this->httpClient, $this->config);
    }

    /**
     * Queries the `scoringgroups` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getScoringGroups(
        ?int $customerId = null
    ): Client\ClientInterface {
        return new ScoringGroupsClient(
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
        ?int $customerId = null
    ): Client\ClientInterface {
        return new ScoringHistoryClient(
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
        ?int $customerId = null
    ): Client\ClientInterface {
        return new TrackingHistoryClient(
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
        return new TrackingTypesClient($this->requestFactory, $this->httpClient, $this->config);
    }

    /**
     * Queries the `newslettersendlogs` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getNewsletterSendlogs(int $customerId): Client\ClientInterface
    {
        return new NewsletterSendlogsClient(
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
        return new MilestoneProfileClient(
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
        return new CampaignProfileHistoryClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $campaignId,
        );
    }

    /**
     * Queries the `scoringcluster` table
     *
     * Returns the scoring cluster configuration for the users' current context
     */
    public function getScoringCluster(): Client\ClientInterface
    {
        return new ScoringClusterClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
        );
    }

    /**
     * Queries the `geocoordinates` table
     *
     * @param int|null $customerId Customer id of the context
     */
    public function getGeoCoordinates(?int $customerId = null): Client\ClientInterface
    {
        return new GeoCoordinatesClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    /**
     * Queries the `articlereferences` table
     *
     * @param int|null $customerId Customer id of the context
     */
    public function getArticleReferences(?int $customerId = null): Client\ClientInterface
    {
        return new ArticleReferencesClient(
            $this->requestFactory,
            $this->httpClient,
            $this->config,
            $customerId,
        );
    }

    /**
     * Creates a new connector instance
     *
     * This utilizes psr client and factory discovery to auto-detect
     * the necessary dependencies. HttpClient and RequestFactory can
     * optionally be provided directly.
     */
    public static function create(
        EvalancheConfigInterface $evalancheConfig,
        null|ClientInterface $httpClient = null,
        null|RequestFactoryInterface $requestFactory = null,
    ): EvalancheConnectionInterface {
        return new self(
            $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory(),
            $httpClient ?? Psr18ClientDiscovery::find(),
            $evalancheConfig
        );
    }
}
