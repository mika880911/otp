<?php

namespace Mika\Otp\Test\Unit;

use Mika\Base32\Base32;
use Mika\Otp\Otp;
use PHPUnit\Framework\TestCase;

class OtpTest extends TestCase
{
    public function test_generateKey(): void
    {
        for ($i = 16; $i < 21; $i++) {
            $this->assertEquals($i, strlen(Base32::decode(Otp::generateSecret($i))));
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
            $this->assertEquals($expectedCode, Otp::getCode('7OVJNCCWPJK6KGCI3E2AFWPENV5HETSV', $counter));
        }
    }
}
