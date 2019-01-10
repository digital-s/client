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

namespace Tarantool\Client\Tests\Unit\Packer;

use PHPUnit\Framework\TestCase;
use Tarantool\Client\Exception\PackerException;
use Tarantool\Client\Packer\PackUtils;

final class PackUtilsTest extends TestCase
{
    public function testPackUnpackLength() : void
    {
        $packed = PackUtils::packLength(42);

        self::assertIsString($packed);
        self::assertSame(42, PackUtils::unpackLength($packed));
    }

    public function testUnpackLengthFromMalformedData() : void
    {
        $this->expectException(PackerException::class);
        $this->expectExceptionMessage('Unable to unpack length value.');

        PackUtils::unpackLength('foo');
    }
}
