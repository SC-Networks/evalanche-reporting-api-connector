<?php

namespace Scn\EvalancheReportingApiConnector;

use Scn\EvalancheReportingApiConnector\Client\ProfilesClient;

class EvalancheConnectionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var EvalancheConfigInterface
     */
    protected $evalancheConfig;
    /**
     * @var EvalancheConnection
     */
    private $subject;
    /**
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    public function setUp()
    {
        $this->httpClient = $this->getMockBuilder(\GuzzleHttp\Client::class)->getMock();
        $this->evalancheConfig = $this->getMockBuilder(EvalancheConfigInterface::class)->getMock();
        $this->subject = new EvalancheConnection(
            $this->evalancheConfig,
            $this->httpClient
        );
    }

    public function testCreateWithDefaultsReturnsInstance()
    {
        $this->assertInstanceOf(
            EvalancheConnection::class,
            $this->subject->create('my-host', 'my-user', 'my-password')
        );
    }

    public function testCreateReturnsInstance()
    {
        $this->assertInstanceOf(
            EvalancheConnection::class,
            $this->subject->create('my-host', 'my-user', 'my-password', 'my-language', 'my-time-format', true)
        );
    }

    /**
     * @dataProvider clientDataProvider
     *
     * @param string $className
     * @param string $method
     */
    public function testGetReturnsClient(string $className, string $method)
    {
        $this->assertInstanceOf(
            $className,
            $this->subject->$method()
        );
    }

    public function clientDataProvider()
    {
        return [
            [Client\CheckpointsClient::class, 'getCheckpoints'],
            [Client\CheckpointStatisticsClient::class, 'getCheckpointStatistics'],
            [Client\CustomersClient::class, 'getCustomers'],
            [Client\FormsClient::class, 'getForms'],
            [Client\LeadpagesClient::class, 'getLeadpages'],
            [Client\MailingsClient::class, 'getMailings'],
            [Client\PoolsClient::class, 'getPools'],
            [Client\ProfileScoresClient::class, 'getProfileScores'],
            [Client\ResourceTypesClient::class, 'getResourceTypes'],
            [Client\ScoringGroupsClient::class, 'getScoringGroups'],
            [Client\ScoringHistoryClient::class, 'getScoringHistory'],
            [Client\TrackingHistoryClient::class, 'getTrackingHistory'],
            [Client\TrackingTypesClient::class, 'getTrackingTypes'],
        ];
    }

    /**
     * @dataProvider clientParamDataProvider
     *
     * @param string $className
     * @param string $method
     * @param int $param
     */
    public function testGetWithParamReturnsClient(string $className, string $method, int $param)
    {
        $this->assertInstanceOf(
            $className,
            $this->subject->$method($param)
        );
    }

    public function clientParamDataProvider()
    {
        return [
            [Client\ProfileChangelogsClient::class, 'getProfileChangelogs', 42],
            [Client\ProfilesClient::class, 'getProfiles', 42],
            [Client\NewsletterSendlogsClient::class, 'getNewsletterSendlogs', 42],
            [Client\MilestoneProfileClient::class, 'getMilestoneProfiles', 42],
        ];
    }
}
