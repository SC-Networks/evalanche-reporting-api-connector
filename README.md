# EVALANCHE REPORTING API CONNECTOR

[![Monthly Downloads](https://poser.pugx.org/scn/evalanche-reporting-api-connector/d/monthly)](https://packagist.org/packages/scn/evalanche-reporting-api-connector)
[![License](https://poser.pugx.org/scn/evalanche-reporting-api-connector/license)](LICENSE)
[![Unittests](https://github.com/SC-Networks/evalanche-reporting-api-connector/actions/workflows/php.yml/badge.svg)](https://github.com/SC-Networks/evalanche-reporting-api-connector/actions/workflows/php.yml)

## Install

Via Composer

``` bash
$ composer require scn/evalanche-reporting-api-connector
```

## Usage

### General

First create a connection with the access credentials provided by SC-Networks.

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

The EvalancheConnection class provides one method for each table. E.g. the method ```getPools()``` queries the table 'pools'.

These methods each return a specific client class, e.g. ```PoolsClient```, to specify further options and to receive the data in different formats.

A minimal working example could be:
```php
$connection->getPools()->asXml();
```

The available methods follow the "Fluent Interface" pattern, which means they enable method chaining.

The call of a format method like ```asXml()``` or ```asCsv()``` is always the last call in the chain, as it returns the data.

#### Methods
The following methods are available:
- ```getArticleReferences(int $customer_id)```
- ```getCustomers()```
- ```getForms()```
- ```getGeoCoordinates(int $customer_id)```
- ```getLeadpages(int $customerId = null)```
- ```getMailings()```
- ```getMilestoneProfiles(int $customer_id)```
- ```getNewsletterSendlogs(int $customer_id)```
- ```getPools()```
- ```getProfileChangelogs(int $pool_id)```
- ```getProfiles(int $pool_id)```
- ```getProfileScores()```
- ```getResourceTypes()```
- ```getScoringCluster()```
- ```getScoringGroups()```
- ```getScoringHistory()```
- ```getTrackingHistory()```
- ```getTrackingTypes()```

#### Formats

At the current state you can choose between the following formats:

##### JsonArray

Example:
```php
$connection->getPools()->asJsonArray();
```

Returns an array of stdClass objects.

##### JsonObject

Example:
```php
$connection->getPools()->asJsonObject();
```

Returns a stdClass object.

##### XML

Example:
```php
$connection->getPools()->asXml();
```

Returns a string, containing valid xml.

##### CSV

Example:
```php
$connection->getPools()->asCsv();
```

Returns a string with comma separated values. The first line contains the column titles.


#### Parameters
Some tables provide further options or mandatory parameters:
##### Customer id (int)
Use it to get the results for a specific customer, instead of the current customer.<br/>
###### Example:
```php
$connection->getLeadpages(1234)->asJsonArray();
```

###### Provided by:
- getLeadpages (optional)
- getNewsletterSendlogs

##### Pool id (int)
Id of the pool you want to get results for.
###### Example:
```php
$connection->getProfiles(123)->asJsonArray();
```

###### Provided by:
- getProfiles
- getLeadpages

#### Time restrictions
Limit the result to a defined time span by using the method ```withTimeRestriction(string $from = null, string $to = null)```. Both parameters are optional and can be replaced by ```null```.

###### Examples:

Everything since yesterday:
```php
$connection
    ->getMailings()
    ->withTimeRestriction('yesterday')
    ->asJsonArray();
```
From date to yesterday:
```php
$connection
    ->getMailings()
    ->withTimeRestriction('2018-09-27', 'yesterday')
    ->asJsonArray();
```
Everything until yesterday:
```php
$connection
    ->getMailings()
    ->withTimeRestriction(null, 'yesterday')
    ->asJsonArray();
```

###### Possible values:
- date: `2018-08-03`, `03.08.2018`
- date and time: `03.08.2018 07:30`
- relative values: `yesterday`, `last monday`, `now-24hours` etc.

###### Provided by:
- getMailings
- getNewsletterSendLogs
- getProfiles
- getScoringHistory
- getTrackingHistory

#### Language
Default language is English, but you can pass a different language code when establishing the connection.

Use the provided Enums in the class `\Scn\EvalancheReportingApiConnector\Enum\Language`

###### Example
```php
use Scn\EvalancheReportingApiConnector\Enum\Language;
use Scn\EvalancheReportingApiConnector\EvalancheConnection;

$connection = EvalancheConnection::create(
    'given host',
    'given username',
    'given password',
    Language::LANG_DE
);
```

###### Possible values
- English: `Language::LANG_EN`
- German: `Language::LANG_DE`
- Italian: `Language::LANG_IT`
- French: `Language::LANG_FR`


#### Time format
Default time format is iso8601, but you can pass a different format code when establishing the connection.

Use the provided Enums in the class `\Scn\EvalancheReportingApiConnector\Enum\TimeFormat`

###### Example
```php
use Scn\EvalancheReportingApiConnector\EvalancheConnection;
use Scn\EvalancheReportingApiConnector\Enum\Language;
use Scn\EvalancheReportingApiConnector\Enum\TimeFormat;

$connection = EvalancheConnection::create(
    'given host',
    'given username',
    'given password',
    Language::LANG_DE,
    TimeFormat::UNIX,
);
```

###### Possible values
- `TimeFormat::ISO8601`
- `TimeFormat::UNIX`
- `TimeFormat::RFC822`
- `TimeFormat::RFC850`
- `TimeFormat::RFC1036`
- `TimeFormat::RFC1123`
- `TimeFormat::RFC2822`
- `TimeFormat::RFC3339`
- `TimeFormat::W3C`

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
