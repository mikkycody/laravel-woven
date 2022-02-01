<?php

/*
 * This file is part of the Laravel Woven package.
 *
 * (c) Michael George <horluwatowbeey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikkycody\Woven\Facades;

use Illuminate\Support\Facades\Facade;

class Woven extends Facade
{
    /**
     * Get the registered name of the component
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-woven';
    }
}
