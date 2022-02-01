<?php

namespace Mikkycody\Woven\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{

    protected $woven;

    public function setUp(): void
    {
        $this->woven = m::mock('Mikkycody\Woven\Woven');
        $this->mock = m::mock('GuzzleHttp\Client');
    }

    public function tearDown(): void
    {
        m::close();
    }

    /**
     * Tests that helper returns
     * @test
     * @return void
     */
    function it_returns_instance_of_woven()
    {
        $this->assertInstanceOf("Mikkycody\Woven\Woven", $this->woven);
    }
}
