<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class CheckpointsClient extends AbstractClient
{
    private $customerId;

    public function __construct(
        ?int $customerId,
        \GuzzleHttp\Client $http_client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        parent::__construct($http_client, $evalancheConfig);
        $this->customerId = $customerId;
    }

    protected function getTableName(): string
    {
        return 'checkpoints';
    }

    protected function getAdditionalParam(): array
    {
        if (null === $this->customerId) {
            return [];
        }
        return ['customer_id' => $this->customerId];
    }
}
