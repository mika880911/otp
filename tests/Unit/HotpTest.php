<?php

namespace Mika\Otp\Test\Unit;

use Mika\Base32\Base32;
use Mika\Otp\Enums\OtpAlgorithm;
use Mika\Otp\Hotp;
use PHPUnit\Framework\TestCase;

class HotpTest extends TestCase
{
    public function test_generate(): void
    {
        $issuer = 'hello';
        $label = 'world';
        $digits = 7;
        $counter = 1;
        $algorithm = OtpAlgorithm::SHA256;

        $actual = Hotp::generate($issuer, $label, $digits, $counter, 20, $algorithm);

        $this->assertNotNull($actual['secret']);
        $this->assertEquals($counter, $actual['counter']);
        $this->assertEquals("otpauth://hotp/{$label}?secret={$actual['secret']}&issuer={$issuer}&algorithm={$algorithm->value}&digits={$digits}&counter={$counter}", $actual['url']);
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
