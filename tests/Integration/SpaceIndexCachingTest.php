<?php

/**
 * This file is part of the tarantool/client package.
 *
 * (c) Eugene Leonovich <gen.work@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tarantool\Client\Tests\Integration;

use Tarantool\Client\Schema\Criteria;
use Tarantool\Client\Schema\Space;

final class SpaceIndexCachingTest extends TestCase
{
    public function testCacheIndex() : void
    {
        $space = $this->client->getSpaceById(Space::VINDEX_ID);
        $space->flushIndexes();

        $this->expectSelectRequestToBeCalled(3);

        $space->select(Criteria::index('name'));
        $space->select(Criteria::index('name'));
    }

    public function testFlushIndexes() : void
    {
        $space = $this->client->getSpaceById(Space::VINDEX_ID);
        $space->flushIndexes();

        $this->expectSelectRequestToBeCalled(4);

        $space->select(Criteria::index('name'));
        $space->flushIndexes();
        $space->select(Criteria::index('name'));
    }
}
