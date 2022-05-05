<?php

namespace Scn\EvalancheReportingApiConnector;

interface EvalancheConnectionInterface
{
    /**
     * Queries the `customers` table
     */
    public function getCustomers(): Client\ClientInterface;

    /**
     * Queries the `forms` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getForms(int $customerId = null): Client\ClientInterface;

    /**
     * Queries the `leadpages` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getLeadpages(int $customerId = null): Client\ClientInterface;

    /**
     * Queries the `mailings` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getMailings(int $customerId = null): Client\ClientInterface;

    /**
     * Queries the `pools` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getPools(int $customerId = null): Client\ClientInterface;

    /**
     * Queries the `profilechangelogs` table
     *
     * @param int $poolId Id of the pool whose profiles should be used
     */
    public function getProfileChangelogs(int $poolId): Client\ClientInterface;

    /**
     * Queries the `profiles` table
     *
     * @param int $poolId Id of the pool whose profiles should be used
     */
    public function getProfiles(int $poolId): Client\ClientInterface;

    /**
     * Queries the `profilescores` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getProfileScores(int $customerId = null): Client\ClientInterface;

    /**
     * Queries the `resourcetypes` table
     */
    public function getResourceTypes(): Client\ClientInterface;

    /**
     * Queries the `scoringgroups` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getScoringGroups(int $customerId = null): Client\ClientInterface;

    /**
     * Queries the `scoringhistory` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getScoringHistory(int $customerId = null): Client\ClientInterface;

    /**
     * Queries the `trackinghistory` table
     *
     * @param int|null $customerId Optional customer id of the context; default is the users current customer
     */
    public function getTrackingHistory(int $customerId = null): Client\ClientInterface;

    /**
     * Queries the `trackingtypes` table
     */
    public function getTrackingTypes(): Client\ClientInterface;

    /**
     * Queries the `newslettersendlogs` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getNewsletterSendlogs(int $customerId): Client\ClientInterface;

    /**
     * Queries the `milestone-profiles` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getMilestoneProfiles(int $customerId): Client\ClientInterface;

    /**
     * Queries the `campaign-profile-history` table
     *
     * @param int $campaignId Id of the campaign whose history should be retrieved
     */
    public function getCampaignProfileHistory(int $campaignId): Client\ClientInterface;

    /**
     * Queries the `scoringcluster` table
     *
     * Returns the scoring cluster configuration for the users' current context
     */
    public function getScoringCluster(): Client\ClientInterface;

    /**
     * Queries the `geocoordinates` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getGeoCoordinates(int $customerId): Client\ClientInterface;

    /**
     * Queries the `articlereferences` table
     *
     * @param int $customerId Customer id of the context
     */
    public function getArticleReferences(int $customerId): Client\ClientInterface;
}
