<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class MilestoneProfileClient extends AbstractClient
{
    public function __construct(
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig,
        private int $customerId,
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
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
