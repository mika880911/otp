<?php

namespace Mika\Otp\Test\Unit;

use Mika\Otp\Enums\OtpAlgorithm;
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
        uopz_set_return('time', 31);

        $codes = [
            '954898',
            '440748',
            '451288'
        ];

        $secret = '7OVJNCCWPJK6KGCI3E2AFWPENV5HETSV';

        foreach ($codes as $code) {
            $this->assertTrue(Totp::verify($code, $secret));
        }

        $this->assertFalse(Totp::verify('123456', $secret));

        uopz_unset_return('time');
    }
}
