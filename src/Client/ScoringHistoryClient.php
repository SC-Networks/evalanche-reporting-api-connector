<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

final class ScoringHistoryClient extends AbstractClient
{
    protected function getTableName(): string
    {
        return 'scoringhistory';
    }

    protected function isRestrictable(): bool
    {
        return true;
    }
}
