<?php

/*
 * This file is part of the Laravel Woven package.
 *
 * (c) Michael George <horluwatowbeey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /**
     * Woven API Secret From Woven Dashboard
     *
     */
    'wovenSecret' => getenv('WOVEN_SECRET'),

    /**
     * Woven API Key From Woven Dashboard
     *
     */
    'wovenKey' => getenv('WOVEN_KEY'),
];
