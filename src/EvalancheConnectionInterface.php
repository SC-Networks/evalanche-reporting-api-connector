<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use Scn\EvalancheReportingApiConnector\Client\ClientInterface;

interface EvalancheConnectionInterface
{
    /**
     * Queries the `customers` table
     */
    public function getCustomers(): ClientInterface;

    /**
     * Queries the `forms` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getForms(?int $customerId = null): ClientInterface;

    /**
     * Queries the `leadpages` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getLeadpages(?int $customerId = null): ClientInterface;

    /**
     * Queries the `mailings` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getMailings(?int $customerId = null): ClientInterface;

    /**
     * Queries the `pools` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getPools(?int $customerId = null): ClientInterface;

    /**
     * Queries the `profilechangelogs` table
     *
     * @param int $poolId Id of the pool whose profiles should be used
     */
    public function getProfileChangelogs(int $poolId): ClientInterface;

    /**
     * Queries the `profiles` table
     *
     * @param int $poolId Id of the pool whose profiles should be used
     */
    public function getProfiles(int $poolId): ClientInterface;

    /**
     * Queries the `profilescores` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getProfileScores(?int $customerId = null): ClientInterface;

    /**
     * Queries the `resourcetypes` table
     */
    public function getResourceTypes(): ClientInterface;

    /**
     * Queries the `scoringgroups` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getScoringGroups(?int $customerId = null): ClientInterface;

    /**
     * Queries the `scoringhistory` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getScoringHistory(?int $customerId = null): ClientInterface;

    /**
     * Queries the `trackinghistory` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getTrackingHistory(?int $customerId = null): ClientInterface;

    /**
     * Queries the `trackingtypes` table
     */
    public function getTrackingTypes(): ClientInterface;

    /**
     * Queries the `newslettersendlogs` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getNewsletterSendlogs(int $customerId): ClientInterface;

    /**
     * Queries the `milestone-profiles` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getMilestoneProfiles(int $customerId): ClientInterface;

    /**
     * Queries the `campaign-profile-history` table
     *
     * @param int $campaignId Id of the campaign whose history should be retrieved
     */
    public function getCampaignProfileHistory(int $campaignId): ClientInterface;

    /**
     * Queries the `scoringcluster` table
     *
     * Returns the scoring cluster configuration for the users' current context
     */
    public function getScoringCluster(): ClientInterface;

    /**
     * Queries the `geocoordinates` table
     *
     * @param int|null $customerId Customer id of the context
     */
    public function getGeoCoordinates(?int $customerId = null): ClientInterface;

    /**
     * Queries the `articlereferences` table
     *
     * @param int|null $customerId Customer id of the context
     */
    public function getArticleReferences(?int $customerId = null): ClientInterface;
}
