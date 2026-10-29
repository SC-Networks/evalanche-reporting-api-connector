<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

use Psr\Http\Client\ClientInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;

class ClientTest extends TestCase
{
    /** @var MockObject&RequestFactoryInterface */
    private MockObject $requestFactory;

    /** @var MockObject&ClientInterface */
    private MockObject $client;

    /** @var MockObject&EvalancheConfigInterface */
    private MockObject $config;

    private string $hostname = 'some-hostname';

    public function setUp(): void
    {
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->client = $this->createMock(ClientInterface::class);
        $this->config = $this->createMock(EvalancheConfigInterface::class);

        $this->config->expects($this->once())
            ->method('getHostname')
            ->willReturn($this->hostname);
    }

    #[DataProvider('clientDataProvider')]
    public function testClientReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname($this->requestFactory, $this->client, $this->config);

        $result = 'some-result';

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'csv',
                'time_format' => 'iso8601',
                'lang' => 'en',
            ],
            $result
        );

        $this->assertSame(
            $result,
            $class->asCsv()
        );
    }

    #[DataProvider('clientDataProvider')]
    public function testClientAsJsonArrayReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname($this->requestFactory, $this->client, $this->config);

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'jsonarray',
                'time_format' => 'iso8601',
                'lang' => 'en',
            ],
            json_encode([[]])
        );

        $this->assertSame(
            [[]],
            $class->asJsonArray()
        );
    }

    #[DataProvider('clientDataProvider')]
    public function testClientAsJsonObjectReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname($this->requestFactory, $this->client, $this->config);

        $key = 'my-key';
        $value = 'my-value';
        $result = json_encode([$key => $value]);

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'jsonobject',
                'time_format' => 'iso8601',
                'lang' => 'en',
            ],
            $result
        );

        $this->assertSame(
            $value,
            $class->asJsonObject()->$key
        );
    }

    #[DataProvider('clientDataProvider')]
    public function testClientAsXmlReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname($this->requestFactory, $this->client, $this->config);

        $key = 'my-key';
        $value = 'my-value';
        $result = '<' . $key . ' value="' . $value . '"></' . $key . '>';

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'xml',
                'time_format' => 'iso8601',
                'lang' => 'en',
            ],
            $result
        );

        $this->assertSame(
            $result,
            $class->asXml()
        );
    }

    public static function clientDataProvider(): array
    {
        return [
            [CustomersClient::class, 'customers'],
            [ResourceTypesClient::class, 'resourcetypes'],
            [TrackingTypesClient::class, 'trackingtypes'],
            [ScoringClusterClient::class, 'scoringcluster'],
        ];
    }

    /**
                 *
                 * @param mixed $additionalParamValue
                 */
    #[DataProvider('clientAdditionalDataProvider')]
    public function testClientWithAdditionalParamReturnsString(
        string $classname,
        string $tablename,
        string $additionalParamName,
        $additionalParamValue
    ): void {
        /** @var AbstractClient $class */
        $class = new $classname(
            $this->requestFactory,
            $this->client,
            $this->config,
            $additionalParamValue,
        );

        $result = 'my-result';

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'csv',
                'time_format' => 'iso8601',
                'lang' => 'en',
                $additionalParamName => $additionalParamValue,
            ],
            $result
        );

        $this->assertSame(
            $result,
            $class->asCsv()
        );
    }

    public static function clientAdditionalDataProvider(): array
    {
        return [
            [ProfilesClient::class, 'profiles', 'pool_id', 42],
            [ProfileChangelogsClient::class, 'profilechangelogs', 'pool_id', 42],
            [LeadpagesClient::class, 'leadpages', 'customer_id', 42],
            [NewsletterSendlogsClient::class, 'newslettersendlogs', 'customer_id', 42],
            [MilestoneProfileClient::class, 'milestone-profiles', 'customer_id', 42],
            [FormsClient::class, 'forms', 'customer_id', 42,],
            [MailingsClient::class, 'mailings', 'customer_id', 42,],
            [PoolsClient::class, 'pools', 'customer_id', 42,],
            [ProfileScoresClient::class, 'profilescores', 'customer_id', 42,],
            [ScoringGroupsClient::class, 'scoringgroups', 'customer_id', 42,],
            [ScoringHistoryClient::class, 'scoringhistory', 'customer_id', 42,],
            [TrackingHistoryClient::class, 'trackinghistory', 'customer_id', 42,],
            [GeoCoordinatesClient::class, 'geocoordinates', 'customer_id', 42,],
            [ArticleReferencesClient::class, 'articlereferences', 'customer_id', 42],
        ];
    }

    #[DataProvider('clientOptionalDataProvider')]
    public function testClientWithoptionalParamReturnsString(
        string $classname,
        string $tablename
    ): void {
        /** @var AbstractClient $class */
        $class = new $classname(
            $this->requestFactory,
            $this->client,
            $this->config,
            null
        );

        $result = 'my-result';

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'csv',
                'time_format' => 'iso8601',
                'lang' => 'en',
            ],
            $result
        );

        $this->assertSame(
            $result,
            $class->asCsv()
        );
    }

    public static function clientOptionalDataProvider(): array
    {
        return [
            [LeadpagesClient::class, 'leadpages'],
        ];
    }

    #[DataProvider('clientRestrictableDataProvider')]
    public function testClientWithTimeRestrictionFromReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname(
            $this->requestFactory,
            $this->client,
            $this->config,
            null,
        );

        $result = 'my-result';

        $from = 'yesterday -1 day';

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'csv',
                'time_format' => 'iso8601',
                'lang' => 'en',
                'from' => urlencode($from),
            ],
            $result
        );

        $this->assertSame(
            $result,
            $class->withTimeRestriction($from)->asCsv()
        );
    }

    #[DataProvider('clientRestrictableDataProvider')]
    public function testClientWithTimeRestrictionToReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname(
            $this->requestFactory,
            $this->client,
            $this->config,
            null,
        );

        $result = 'my-result';

        $to = 'yesterday -1 day';

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'csv',
                'time_format' => 'iso8601',
                'lang' => 'en',
                'to' => urlencode($to),
            ],
            $result
        );

        $this->assertSame(
            $result,
            $class->withTimeRestriction(null, $to)->asCsv()
        );
    }

    #[DataProvider('clientRestrictableDataProvider')]
    public function testClientWithTimeRestrictionFromToReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname(
            $this->requestFactory,
            $this->client,
            $this->config,
            null,
        );

        $result = 'my-result';

        $from = '28.09.2018';
        $to = 'yesterday -1 day';

        $this->createRequestExpectations(
            [
                'table' => $tablename,
                'format' => 'csv',
                'time_format' => 'iso8601',
                'lang' => 'en',
                'from' => urlencode($from),
                'to' => urlencode($to),
            ],
            $result
        );

        $this->assertSame(
            $result,
            $class->withTimeRestriction($from, $to)->asCsv()
        );
    }

    public static function clientRestrictableDataProvider(): array
    {
        return [
            [MailingsClient::class, 'mailings'],
            [ScoringHistoryClient::class, 'scoringhistory'],
            [TrackingHistoryClient::class, 'trackinghistory'],
            [ArticleReferencesClient::class, 'articlereferences'],
        ];
    }

    public function testConnectorPassesClientExceptionThru(): void
    {
        $this->expectException(ClientExceptionInterface::class);

        $request = $this->createStub(RequestInterface::class);

        /** @var AbstractClient $class */
        $class = new ScoringHistoryClient(
            $this->requestFactory,
            $this->client,
            $this->config,
            null,
        );

        $this->config->expects($this->once())
            ->method('getTimeFormat')
            ->willReturn('iso8601');

        $this->config->expects($this->once())
            ->method('getLanguage')
            ->willReturn('en');

        $this->client->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willThrowException($this->createStub(ClientExceptionInterface::class));

        $this->requestFactory->expects($this->once())
            ->method('createRequest')
            ->withAnyParameters()
            ->willReturn($request);

        $class->asCsv();
    }

    private function createRequestExpectations(array $params, $result): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $body = $this->createMock(StreamInterface::class);
        $request = $this->createStub(RequestInterface::class);

        $this->config->expects($this->once())
            ->method('getTimeFormat')
            ->willReturn('iso8601');
        $this->config->expects($this->once())
            ->method('getLanguage')
            ->willReturn('en');

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($body);

        $body->expects($this->once())
            ->method('getContents')
            ->willReturn($result);

        $this->requestFactory->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                sprintf(
                    'https://%s/report.php?%s',
                    $this->hostname,
                    http_build_query($params)
                )
            )
            ->willReturn($request);

        $this->client->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);
    }
}
