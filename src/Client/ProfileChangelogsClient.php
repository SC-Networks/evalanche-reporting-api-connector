<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class ProfileChangelogsClient extends AbstractClient
{
    public function __construct(
        private int $pool_id,
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
    }

    protected function getTableName(): string
    {
        return 'profilechangelogs';
    }

    protected function getAdditionalParam(): array
    {
        return ['pool_id' => $this->pool_id];
    }

    protected function isRestrictable(): bool
    {
        return true;
    }
}
