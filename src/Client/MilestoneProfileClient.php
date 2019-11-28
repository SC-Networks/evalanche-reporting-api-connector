<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class MilestoneProfileClient extends AbstractClient
{
    private $customerId;

    public function __construct(
        int $customerId,
        \GuzzleHttp\Client $httpClient,
        EvalancheConfigInterface $evalancheConfig
    )
    {
        parent::__construct($httpClient, $evalancheConfig);
        $this->customerId = $customerId;
    }

    protected function isRestrictable(): bool
    {
        return true;
    }

    protected function getAdditionalParam(): array
    {
        return ['customer_id' => $this->customerId];
    }

    protected function getTableName(): string
    {
        return 'milestone-profiles';
    }
}
