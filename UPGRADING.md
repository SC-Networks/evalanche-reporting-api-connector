# 2.0.0

The parameter of the `EvalancheConnection::create` method have changed.

Prior to version 2.

```php
$connection = \Scn\EvalancheReportingApiConnector\EvalancheConnection::create(
    'given host',
    'given username',
    'given password'
);
```

And beginning with version 2.

```php
use Scn\EvalancheReportingApiConnector\Enum\Language;
use Scn\EvalancheReportingApiConnector\Enum\TimeFormat;
use Scn\EvalancheReportingApiConnector\EvalancheConfig;
use Scn\EvalancheReportingApiConnector\EvalancheConnection;

$connection = EvalancheConnection::create(
    new EvalancheConfig(
        'your evalanche hostname (no uri, just the hostname)',
        'username',
        'password',
        Language::LANG_EN,
        TimeFormat::ISO8601,
    ),
    // $requestFactory, (optional existing PSR-17 RequestFactory instance)
    // $httpClient, (optional existing PSR-18 Http-Client instance)
);
```
