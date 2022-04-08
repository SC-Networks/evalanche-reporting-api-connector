<?php

namespace Scn\EvalancheReportingApiConnector;

interface EvalancheConnectionInterface
{
    public function getCustomers(): Client\ClientInterface;

    public function getForms(int $customerId = null): Client\ClientInterface;

    public function getLeadpages(int $customerId = null): Client\ClientInterface;

    public function getMailings(int $customerId = null): Client\ClientInterface;

    public function getPools(int $customerId = null): Client\ClientInterface;

    public function getProfileChangelogs(int $poolId): Client\ClientInterface;

    public function getProfiles(int $poolId): Client\ClientInterface;

    public function getProfileScores(int $customerId = null): Client\ClientInterface;

    public function getResourceTypes(): Client\ClientInterface;

    public function getScoringGroups(int $customerId = null): Client\ClientInterface;

    public function getScoringHistory(int $customerId = null): Client\ClientInterface;

    public function getTrackingHistory(int $customerId = null): Client\ClientInterface;

    public function getTrackingTypes(): Client\ClientInterface;

    public function getNewsletterSendlogs(int $customerId): Client\ClientInterface;

    public function getMilestoneProfiles(int $customerId): Client\ClientInterface;

    public function getCampaignProfileHistory(int $campaignId): Client\ClientInterface;
}
