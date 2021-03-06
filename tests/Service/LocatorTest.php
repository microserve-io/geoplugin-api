<?php

namespace Microserve\Geoplugin\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Microserve\Geoplugin\Service\Locator;
use PHPUnit\Framework\TestCase;

class LocatorTest extends TestCase
{
    /**
     * @var \Microserve\Geoplugin\Service\Locator
     */
    private $locator;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $mock = new MockHandler([
            new Response(200, [], serialize([
                Locator::FIELD_COUNTRY_CODE => 'GB',
                Locator::FIELD_COUNTRY_NAME => 'United Kingdom',
                Locator::FIELD_IP_ADDRESS => '1.2.3.4',
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->locator = new Locator($client);
    }

    /** @test */
    public function can_retrieve_the_country_code()
    {
        $this->assertSame('GB', $this->locator->execute()->getCountryCode());
    }

    /** @test */
    public function can_retrieve_the_ip_address()
    {
        $this->assertSame('1.2.3.4', $this->locator->execute()->getIpAddress());
    }
}
