<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class ProfileChangelogsClient extends AbstractClient
{
    private $pool_id;

    public function __construct(
        int $pool_id,
        \GuzzleHttp\Client $http_client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        parent::__construct($http_client, $evalancheConfig);
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
