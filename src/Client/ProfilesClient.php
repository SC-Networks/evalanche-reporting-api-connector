<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class ProfilesClient extends AbstractClient
{
    public function __construct(
        private int $poolId,
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
    }

    protected function isRestrictable(): bool
    {
        return true;
    }

    protected function getTableName(): string
    {
        return 'profiles';
    }

    protected function getAdditionalParam(): array
    {
        return ['pool_id' => $this->poolId];
    }
}
