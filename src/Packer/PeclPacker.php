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

namespace Tarantool\Client\Packer;

use Tarantool\Client\Exception\PackerException;
use Tarantool\Client\IProto;
use Tarantool\Client\Request\Request;
use Tarantool\Client\Response\RawResponse;

final class PeclPacker implements Packer
{
    private $packer;
    private $unpacker;

    public function __construct($phpOnly = true)
    {
        $this->packer = new \MessagePack($phpOnly);
        $this->unpacker = new \MessagePackUnpacker($phpOnly);
    }

    public function pack(Request $request, int $sync = null) : string
    {
        // @see https://github.com/msgpack/msgpack-php/issues/45
        $content = \pack('C*', 0x82, IProto::CODE, $request->getType(), IProto::SYNC).
            $this->packer->pack($sync ?: 0).
            $this->packer->pack($request->getBody());

        return PackUtils::packLength(\strlen($content)).$content;
    }

    public function unpack(string $data) : RawResponse
    {
        $this->unpacker->feed($data);

        if (!$this->unpacker->execute()) {
            throw new PackerException('Unable to unpack data.');
        }

        $header = $this->unpacker->data();

        if (!$this->unpacker->execute()) {
            throw new PackerException('Unable to unpack data.');
        }

        $body = (array) $this->unpacker->data();

        try {
            return new RawResponse($header, $body);
        } catch (\TypeError $e) {
            throw new PackerException('Unable to unpack data.', 0, $e);
        }
    }
}
