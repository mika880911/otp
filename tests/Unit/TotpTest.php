<?php

namespace Mika\Otp\Test\Unit;

use Mika\Otp\Enums\OtpAlgorithm;
use Mika\Otp\Otp;
use Mika\Otp\Totp;
use PHPUnit\Framework\TestCase;

class TotpTest extends TestCase
{
    public function test_generate(): void
    {
        $issuer = 'hello';
        $label = 'world';
        $digits = 7;
        $period = 60;
        $algorithm = OtpAlgorithm::SHA256;

        $actual = Totp::generate($issuer, $label, $digits, $period, 20, $algorithm);

        $this->assertNotNull($actual['secret']);
        $this->assertEquals("otpauth://totp/{$label}?secret={$actual['secret']}&issuer={$issuer}&algorithm={$algorithm->value}&digits={$digits}&period={$period}", $actual['url']);
    }

    public function test_verify(): void
    {
        $secret = Otp::generateSecret();

        for ($i = -1; $i < 2; $i++) {
            $code = Otp::getCode($secret, floor(time() / 30) + $i);
            $this->assertTrue(Totp::verify($code, $secret));
        }

        $this->assertFalse(Totp::verify('123456', $secret));
    }
}
