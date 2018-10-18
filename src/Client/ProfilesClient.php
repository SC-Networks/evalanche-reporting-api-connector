<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class ProfilesClient extends AbstractClient
{
    private $poolId;

    public function __construct(int $poolId, \GuzzleHttp\Client $http_client, EvalancheConfigInterface $evalancheConfig)
    {
        parent::__construct($http_client, $evalancheConfig);
        $this->poolId = $poolId;
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
