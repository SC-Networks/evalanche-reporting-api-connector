<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class ProfileChangelogsClient extends AbstractClient
{
    private int $pool_id;

    public function __construct(
        int $pool_id,
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
        $this->pool_id = $pool_id;
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
