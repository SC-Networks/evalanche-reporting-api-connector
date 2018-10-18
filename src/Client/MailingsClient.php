<?php
declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

final class MailingsClient extends AbstractClient
{
    protected function getTableName(): string
    {
        return 'mailings';
    }

    protected function isRestrictable(): bool
    {
        return true;
    }
}
