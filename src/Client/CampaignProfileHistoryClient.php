<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class CampaignProfileHistoryClient extends AbstractClient
{
    public function __construct(
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig,
        private int $campaignId,
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
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
