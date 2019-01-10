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

namespace Tarantool\Client\Schema;

final class Index
{
    public const SPACE_PRIMARY = 0;
    public const SPACE_NAME = 2;
    public const INDEX_PRIMARY = 0;
    public const INDEX_NAME = 2;

    private function __construct()
    {
    }
}
