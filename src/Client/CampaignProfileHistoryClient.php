<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class CampaignProfileHistoryClient extends AbstractClient
{
    private int $campaignId;

    public function __construct(
        int $campaignId,
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
        $this->campaignId = $campaignId;
    }

    protected function getTableName(): string
    {
        return 'campaign-profile-history';
    }

    /**
     * @return array<string, int>
     */
    protected function getAdditionalParam(): array
    {
        return ['campaign_id' => $this->campaignId];
    }
}
