<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

final class TrackingHistoryClient extends AbstractClient
{
    protected function getTableName(): string
    {
        return 'trackinghistory';
    }

    protected function isRestrictable(): bool
    {
        return true;
    }
}
