<?php

/*
 * This file is part of the Laravel Woven package.
 *
 * (c) Michael George <horluwatowbeey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikkycody\Woven\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class WovenTest extends TestCase
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

    public function testShouldReturnAllAccounts()
    {
        $array = $this->woven->shouldReceive('fetchAccounts')->andReturn(['accounts']);

        $this->assertEquals('array', gettype(array($array)));
    }

 
}
