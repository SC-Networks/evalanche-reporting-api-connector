<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector\Client;

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
    /** @var RequestFactoryInterface|MockObject|null */
    private $requestFactory;

    /** @var \Psr\Http\Client\ClientInterface|MockObject|null */
    private $client;

    /** @var EvalancheConfigInterface|MockObject|null */
    private $config;

    private $hostname = 'some-hostname';

    public function setUp(): void
    {
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->client = $this->createMock(\Psr\Http\Client\ClientInterface::class);
        $this->config = $this->createMock(EvalancheConfigInterface::class);

        $this->config->expects($this->once())
            ->method('getHostname')
            ->willReturn($this->hostname);
    }

    /**
     * @dataProvider clientDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
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

    /**
     * @dataProvider clientDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
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

    /**
     * @dataProvider clientDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
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

    /**
     * @dataProvider clientDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
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

    public function clientDataProvider(): array
    {
        return [
            [CheckpointStatisticsClient::class, 'checkpointstatistics'],
            [CustomersClient::class, 'customers'],
            [FormsClient::class, 'forms'],
            [MailingsClient::class, 'mailings'],
            [PoolsClient::class, 'pools'],
            [ProfileScoresClient::class, 'profilescores'],
            [ResourceTypesClient::class, 'resourcetypes'],
            [ScoringGroupsClient::class, 'scoringgroups'],
            [ScoringHistoryClient::class, 'scoringhistory'],
            [TrackingHistoryClient::class, 'trackinghistory'],
            [TrackingTypesClient::class, 'trackingtypes'],
        ];
    }

    /**
     * @dataProvider clientAdditionalDataProvider
     *
     * @param string $classname
     * @param string $tablename
     * @param string $additionalParamName
     * @param mixed $additionalParamValue
     */
    public function testClientWithAdditionalParamReturnsString(
        string $classname,
        string $tablename,
        string $additionalParamName,
        $additionalParamValue
    ): void {
        /** @var AbstractClient $class */
        $class = new $classname($additionalParamValue, $this->requestFactory, $this->client, $this->config);

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

    public function clientAdditionalDataProvider(): array
    {
        return [
            [ProfilesClient::class, 'profiles', 'pool_id', 42],
            [ProfileChangelogsClient::class, 'profilechangelogs', 'pool_id', 42],
            [LeadpagesClient::class, 'leadpages', 'customer_id', 42],
            [CheckpointsClient::class, 'checkpoints', 'customer_id', 42],
            [NewsletterSendlogsClient::class, 'newslettersendlogs', 'customer_id', 42],
            [MilestoneProfileClient::class, 'milestone-profiles', 'customer_id', 42],
        ];
    }

    /**
     * @dataProvider clientOptionalDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
    public function testClientWithoptionalParamReturnsString(
        string $classname,
        string $tablename
    ): void {
        /** @var AbstractClient $class */
        $class = new $classname(null, $this->requestFactory, $this->client, $this->config);

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

    public function clientOptionalDataProvider(): array
    {
        return [
            [LeadpagesClient::class, 'leadpages'],
            [CheckpointsClient::class, 'checkpoints'],
        ];
    }

    /**
     * @dataProvider clientRestrictableDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
    public function testClientWithTimeRestrictionFromReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname($this->requestFactory, $this->client, $this->config);

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

    /**
     * @dataProvider clientRestrictableDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
    public function testClientWithTimeRestrictionToReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname($this->requestFactory, $this->client, $this->config);

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

    /**
     * @dataProvider clientRestrictableDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
    public function testClientWithTimeRestrictionFromToReturnsString(string $classname, string $tablename): void
    {
        /** @var AbstractClient $class */
        $class = new $classname($this->requestFactory, $this->client, $this->config);

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

    public function clientRestrictableDataProvider()
    {
        return [
            [MailingsClient::class, 'mailings'],
            [ScoringHistoryClient::class, 'scoringhistory'],
            [TrackingHistoryClient::class, 'trackinghistory'],
        ];
    }

    public function testConnectorPassesClientExceptionThru(): void
    {
        $this->expectException(ClientExceptionInterface::class);

        $request = $this->createMock(RequestInterface::class);

        /** @var AbstractClient $class */
        $class = new ScoringHistoryClient($this->requestFactory, $this->client, $this->config);

        $this->config->expects($this->once())
            ->method('getTimeFormat')
            ->willReturn('iso8601');

        $this->config->expects($this->once())
            ->method('getLanguage')
            ->willReturn('en');

        $this->client->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willThrowException($this->createMock(ClientExceptionInterface::class));

        $this->requestFactory->expects($this->once())
            ->method('createRequest')
            ->withAnyParameters()
            ->willReturn($request);

        $class->asCsv();
    }

    private function createRequestExpectations(array $params, $result): void
    {
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $body = $this->getMockBuilder(StreamInterface::class)->getMock();
        $request = $this->createMock(RequestInterface::class);

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
