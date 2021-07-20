<?php

declare(strict_types=1);

namespace Scn\EvalancheReportingApiConnector;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class EvalancheConnectionTest extends TestCase
{
    /** @var EvalancheConfigInterface|MockObject|null */
    protected MockObject $evalancheConfig;

    /** @var EvalancheConnection|null */
    private EvalancheConnection $subject;

    /** @var ClientInterface|MockObject|null */
    private MockObject $httpClient;

    /** @var RequestFactoryInterface|MockObject|null */
    private MockObject $requestFactory;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->evalancheConfig = $this->createMock(EvalancheConfigInterface::class);

        $this->subject = new EvalancheConnection(
            $this->requestFactory,
            $this->httpClient,
            $this->evalancheConfig
        );
    }

    /**
     * @dataProvider clientDataProvider
     *
     * @param string $className
     * @param string $method
     */
    public function testGetReturnsClient(string $className, string $method): void
    {
        $this->assertInstanceOf(
            $className,
            $this->subject->$method()
        );
    }

    public function clientDataProvider(): array
    {
        return [
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
    public function testGetWithParamReturnsClient(string $className, string $method, int $param): void
    {
        $this->assertInstanceOf(
            $className,
            $this->subject->$method($param)
        );
    }

    public function clientParamDataProvider(): array
    {
        return [
            [Client\ProfileChangelogsClient::class, 'getProfileChangelogs', 42],
            [Client\ProfilesClient::class, 'getProfiles', 42],
            [Client\NewsletterSendlogsClient::class, 'getNewsletterSendlogs', 42],
            [Client\MilestoneProfileClient::class, 'getMilestoneProfiles', 42],
            [Client\CampaignProfileHistoryClient::class, 'getCampaignProfileHistory', 42],
        ];
    }
}
