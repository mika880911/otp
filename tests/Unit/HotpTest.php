<?php

namespace Mika\Otp\Test\Unit;

use Mika\Base32\Base32;
use Mika\Otp\Hotp;
use PHPUnit\Framework\TestCase;

class HotpTest extends TestCase
{
    public function test_generateKey(): void
    {
        for ($i = 16; $i < 21; $i++) {
            $this->assertEquals($i, strlen(Base32::decode(Hotp::generateSecret($i))));
        }
    }
}
