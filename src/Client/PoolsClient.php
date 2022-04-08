<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class PoolsClient extends AbstractClient
{
    public function __construct(
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig,
        private ?int $customerId,
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
    }

    protected function getTableName(): string
    {
        return 'pools';
    }

    protected function getAdditionalParam(): array
    {
        if (null === $this->customerId) {
            return [];
        }
        return ['customer_id' => $this->customerId];
    }
}
