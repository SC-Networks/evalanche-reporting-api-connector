<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

final class CheckpointStatisticsClient extends AbstractClient
{
    protected function getTableName(): string
    {
        return 'checkpointstatistics';
    }

    protected function isRestrictable(): bool
    {
        return true;
    }
}
