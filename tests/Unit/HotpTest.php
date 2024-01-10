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

    public function test_getCode(): void
    {
        $expectedCodes = [
            '954898',
            '440748',
            '451288',
            '880908',
            '154819'
        ];

        foreach ($expectedCodes as $counter => $expectedCode) {
            $this->assertEquals($expectedCode, Hotp::getCode('7OVJNCCWPJK6KGCI3E2AFWPENV5HETSV', $counter));
        }
    }

    public function test_verify(): void
    {
        $expectedCodes = [
            '954898',
            '440748',
            '451288',
            '880908',
            '154819'
        ];

        foreach ($expectedCodes as $counter => $expectedCode) {
            $this->assertTrue(Hotp::verify($expectedCode, '7OVJNCCWPJK6KGCI3E2AFWPENV5HETSV', $counter));
        }
    }
}
