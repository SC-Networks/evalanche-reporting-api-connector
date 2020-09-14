<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

final class ResourceTypesClient extends AbstractClient
{
    protected function getTableName(): string
    {
        return 'resourcetypes';
    }
}
