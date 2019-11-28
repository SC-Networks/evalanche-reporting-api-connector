<?php

namespace Scn\EvalancheReportingApiConnector\Client;

use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Scn\EvalancheReportingApiConnector\EvalancheConfigInterface;
use Scn\EvalancheReportingApiConnector\Exception\AuthorizationException;
use Scn\EvalancheReportingApiConnector\Exception\ConnectionException;
use Scn\EvalancheReportingApiConnector\Exception\InvalidParamException;
use Scn\EvalancheReportingApiConnector\Exception\UnreachableEndpointException;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider clientDataProvider
     *
     * @param string $classname
     * @param string $tablename
     */
    public function testClientReturnsString(string $classname, string $tablename)
    {
        $httpClient = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname($httpClient, $evalancheConfig);

        $result = 'my-result';
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'csv',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                    ],
                ])
            ->willReturn($response);

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
    public function testClientAsJsonArrayReturnsString(string $classname, string $tablename)
    {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname($http_client, $evalancheConfig);

        $result = json_encode([[]]);
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'jsonarray',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                    ],
                ])
            ->willReturn($response);

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
    public function testClientAsJsonObjectReturnsString(string $classname, string $tablename)
    {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname($http_client, $evalancheConfig);

        $key = 'my-key';
        $value = 'my-value';
        $result = json_encode([$key => $value]);
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'jsonobject',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                    ],
                ])
            ->willReturn($response);

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
    public function testClientAsXmlReturnsString(string $classname, string $tablename)
    {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname($http_client, $evalancheConfig);

        $key = 'my-key';
        $value = 'my-value';
        $result = '<' . $key . ' value="' . $value . '"></' . $key . '>';
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'xml',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                    ],
                ])
            ->willReturn($response);

        $this->assertSame(
            $result,
            $class->asXml()
        );
    }

    public function clientDataProvider()
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
    ) {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname($additionalParamValue, $http_client, $evalancheConfig);

        $result = 'my-result';
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'csv',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                        $additionalParamName => $additionalParamValue,
                    ],
                ])
            ->willReturn($response);

        $this->assertSame(
            $result,
            $class->asCsv()
        );
    }

    public function clientAdditionalDataProvider()
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
    ) {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname(null, $http_client, $evalancheConfig);

        $result = 'my-result';
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'csv',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                    ],
                ])
            ->willReturn($response);

        $this->assertSame(
            $result,
            $class->asCsv()
        );
    }

    public function clientOptionalDataProvider()
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
    public function testClientWithTimeRestrictionFromReturnsString(string $classname, string $tablename)
    {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname($http_client, $evalancheConfig);

        $result = 'my-result';
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $from = 'yesterday -1 day';

        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'csv',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                        'from' => urlencode($from),
                    ],
                ])
            ->willReturn($response);

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
    public function testClientWithTimeRestrictionToReturnsString(string $classname, string $tablename)
    {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname($http_client, $evalancheConfig);

        $result = 'my-result';
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $to = 'yesterday -1 day';

        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'csv',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                        'to' => urlencode($to),
                    ],
                ])
            ->willReturn($response);

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
    public function testClientWithTimeRestrictionFromToReturnsString(string $classname, string $tablename)
    {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new $classname($http_client, $evalancheConfig);

        $result = 'my-result';
        $response = $this->makeBasicExpectations($evalancheConfig, $result);

        $from = '28.09.2018';
        $to = 'yesterday -1 day';

        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => $tablename,
                        'format' => 'csv',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                        'from' => urlencode($from),
                        'to' => urlencode($to),
                    ],
                ])
            ->willReturn($response);

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

    public function testClientThrowsExceptionWhenNotConnected()
    {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new ScoringHistoryClient($http_client, $evalancheConfig);

        $evalancheConfig
            ->expects($this->once())
            ->method('getTimeFormat')
            ->willReturn('iso8601');

        $evalancheConfig
            ->expects($this->once())
            ->method('getLanguage')
            ->willReturn('en');

        $message = 'my-message';
        $exception = new ConnectException($message, $this->getMockBuilder(RequestInterface::class)->getMock());
        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => 'scoringhistory',
                        'format' => 'csv',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                    ],
                ])
            ->willThrowException($exception);

        $this->expectException(ConnectionException::class);
        $this->expectExceptionMessage($message);
        $class->asCsv();
    }

    /**
     * @dataProvider exceptionDataProvider
     *
     * @param int $errorCode
     * @param string $exceptionClass
     */
    public function testClientThrowsExceptionOnInvalidParam(int $errorCode, string $exceptionClass)
    {
        $http_client = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();

        /** @var AbstractClient $class */
        $class = new ScoringHistoryClient($http_client, $evalancheConfig);

        $evalancheConfig
            ->expects($this->once())
            ->method('getTimeFormat')
            ->willReturn('iso8601');

        $evalancheConfig
            ->expects($this->once())
            ->method('getLanguage')
            ->willReturn('en');

        $message = 'my-message';
        $exception = new \Exception($message, $errorCode);
        $http_client
            ->expects($this->once())
            ->method('request')
            ->with('GET',
                'report.php',
                [
                    'query' => [
                        'table' => 'scoringhistory',
                        'format' => 'csv',
                        'time_format' => 'iso8601',
                        'lang' => 'en',
                    ],
                ])
            ->willThrowException($exception);

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($message);
        $class->asCsv();
    }

    public function exceptionDataProvider()
    {
        return [
            [400, InvalidParamException::class],
            [401, AuthorizationException::class],
            [404, UnreachableEndpointException::class],
            [666, \Exception::class],
        ];
    }

    private function makeBasicExpectations($evalancheConfig, $result): \PHPUnit\Framework\MockObject\MockObject
    {
        $evalancheConfig
            ->expects($this->once())
            ->method('getTimeFormat')
            ->willReturn('iso8601');

        $evalancheConfig
            ->expects($this->once())
            ->method('getLanguage')
            ->willReturn('en');

        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $body = $this->getMockBuilder(StreamInterface::class)->getMock();
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($body);
        $body
            ->expects($this->once())
            ->method('getContents')
            ->willReturn($result);
        return $response;
    }
}
