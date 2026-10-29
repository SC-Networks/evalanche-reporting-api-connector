<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\Attributes\DataProvider;
use Scn\EvalancheReportingApiConnector\Client\CustomersClient;
use Scn\EvalancheReportingApiConnector\Client\FormsClient;
use Scn\EvalancheReportingApiConnector\Client\LeadpagesClient;
use Scn\EvalancheReportingApiConnector\Client\MailingsClient;
use Scn\EvalancheReportingApiConnector\Client\PoolsClient;
use Scn\EvalancheReportingApiConnector\Client\ProfileScoresClient;
use Scn\EvalancheReportingApiConnector\Client\ResourceTypesClient;
use Scn\EvalancheReportingApiConnector\Client\ScoringGroupsClient;
use Scn\EvalancheReportingApiConnector\Client\ScoringHistoryClient;
use Scn\EvalancheReportingApiConnector\Client\TrackingHistoryClient;
use Scn\EvalancheReportingApiConnector\Client\TrackingTypesClient;
use Scn\EvalancheReportingApiConnector\Client\ScoringClusterClient;
use Scn\EvalancheReportingApiConnector\Client\ProfileChangelogsClient;
use Scn\EvalancheReportingApiConnector\Client\ProfilesClient;
use Scn\EvalancheReportingApiConnector\Client\NewsletterSendlogsClient;
use Scn\EvalancheReportingApiConnector\Client\MilestoneProfileClient;
use Scn\EvalancheReportingApiConnector\Client\CampaignProfileHistoryClient;
use Scn\EvalancheReportingApiConnector\Client\GeoCoordinatesClient;
use Scn\EvalancheReportingApiConnector\Client\ArticleReferencesClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class EvalancheConnectionTest extends TestCase
{
    /** @var Stub&EvalancheConfigInterface */
    protected Stub $evalancheConfig;

    private EvalancheConnection $subject;

    /** @var Stub&ClientInterface */
    private Stub $httpClient;

    /** @var Stub&RequestFactoryInterface */
    private Stub $requestFactory;

    public function setUp(): void
    {
        $this->httpClient = $this->createStub(ClientInterface::class);
        $this->requestFactory = $this->createStub(RequestFactoryInterface::class);
        $this->evalancheConfig = $this->createStub(EvalancheConfigInterface::class);

        $this->subject = new EvalancheConnection(
            $this->requestFactory,
            $this->httpClient,
            $this->evalancheConfig
        );
    }

    #[DataProvider('clientDataProvider')]
    public function testGetReturnsClient(string $className, string $method): void
    {
        $this->assertInstanceOf(
            $className,
            $this->subject->$method()
        );
    }

    public static function clientDataProvider(): array
    {
        return [
            [CustomersClient::class, 'getCustomers'],
            [FormsClient::class, 'getForms'],
            [LeadpagesClient::class, 'getLeadpages'],
            [MailingsClient::class, 'getMailings'],
            [PoolsClient::class, 'getPools'],
            [ProfileScoresClient::class, 'getProfileScores'],
            [ResourceTypesClient::class, 'getResourceTypes'],
            [ScoringGroupsClient::class, 'getScoringGroups'],
            [ScoringHistoryClient::class, 'getScoringHistory'],
            [TrackingHistoryClient::class, 'getTrackingHistory'],
            [TrackingTypesClient::class, 'getTrackingTypes'],
            [ScoringClusterClient::class, 'getScoringCluster'],
        ];
    }

    #[DataProvider('clientParamDataProvider')]
    public function testGetWithParamReturnsClient(string $className, string $method, int $param): void
    {
        $this->assertInstanceOf(
            $className,
            $this->subject->$method($param)
        );
    }

    public static function clientParamDataProvider(): array
    {
        return [
            [ProfileChangelogsClient::class, 'getProfileChangelogs', 42],
            [ProfilesClient::class, 'getProfiles', 42],
            [NewsletterSendlogsClient::class, 'getNewsletterSendlogs', 42],
            [MilestoneProfileClient::class, 'getMilestoneProfiles', 42],
            [CampaignProfileHistoryClient::class, 'getCampaignProfileHistory', 42],
            [GeoCoordinatesClient::class, 'getGeoCoordinates', 666],
            [ArticleReferencesClient::class, 'getArticleReferences', 666],
        ];
    }

    public function testCreateCreatesInstanceWithAutoDiscovry(): void
    {
        $config = $this->createStub(EvalancheConfigInterface::class);

        $this->assertInstanceOf(
            EvalancheConnection::class,
            EvalancheConnection::create($config)
        );
    }
}
