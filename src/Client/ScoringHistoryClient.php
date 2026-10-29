<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class ScoringHistoryClient extends AbstractClient
{
    public function __construct(
        RequestFactoryInterface $requestFactory,
        ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig,
        private readonly ?int $customerId,
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
    }

    protected function getTableName(): string
    {
        return 'scoringhistory';
    }

    protected function isRestrictable(): bool
    {
        return true;
    }

    protected function getAdditionalParam(): array
    {
        if (null === $this->customerId) {
            return [];
        }
        return ['customer_id' => $this->customerId];
    }
}
