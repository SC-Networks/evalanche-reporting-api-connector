<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class NewsletterSendlogsClient extends AbstractClient
{
    private $customerId;

    public function __construct(
        int $customerId,
        \GuzzleHttp\Client $http_client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        parent::__construct($http_client, $evalancheConfig);
        $this->customerId = $customerId;
    }

    protected function isRestrictable(): bool
    {
        return true;
    }

    protected function getTableName(): string
    {
        return 'newslettersendlogs';
    }

    protected function getAdditionalParam(): array
    {
        return ['customer_id' => $this->customerId];
    }
}
