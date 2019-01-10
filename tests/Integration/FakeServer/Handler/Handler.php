<?php

declare(strict_types=1);

/*
 * This file is part of the Tarantool Client package.
 *
 * (c) Eugene Leonovich <gen.work@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tarantool\Client\Tests\Integration\FakeServer\Handler;

interface Handler
{
    /**
     * @param resource $conn
     */
    public function __invoke($conn, string $sid) : ?bool;
}
