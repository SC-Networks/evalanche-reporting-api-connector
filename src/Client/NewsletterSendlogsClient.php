<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Message\RequestFactoryInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

final class NewsletterSendlogsClient extends AbstractClient
{
    private ?int $customerId;

    public function __construct(
        int $customerId,
        RequestFactoryInterface $requestFactory,
        \Psr\Http\Client\ClientInterface $client,
        EvalancheConfigInterface $evalancheConfig
    ) {
        parent::__construct($requestFactory, $client, $evalancheConfig);
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
