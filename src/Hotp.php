<?php

namespace Mika\Otp;

use Exception;
use Mika\Base32\Base32;
use Mika\Otp\Enums\OtpAlgorithm;

class Hotp
{
    /**
     * Generate a secret.
     *
     * @param int $length
     * @return string
     * @throws Exception
     */
    public static function generateSecret(int $length = 20): string
    {
        return rtrim(Base32::encode(random_bytes($length)), '=');
    }

    /**
     * Get otp code.
     *
     * @param string $secret
     * @param int $counter
     * @param int $step
     * @param int $digits
     * @param OtpAlgorithm $algorithm
     * @return string
     */
    public static function getCode(
        string $secret,
        int $counter,
        int $step = 0,
        int $digits = 6,
        OtpAlgorithm $algorithm = OtpAlgorithm::SHA1
    ): string {
        $c = pack('N*', 0, $counter + $step);
        $binary = hash_hmac($algorithm->value, $c, Base32::decode($secret), true);
        $offset = ord($binary[-1]) & 0x0F;

        return str_pad((
            (ord($binary[$offset]) & 0x7F) << 24 |
            (ord($binary[$offset + 1]) & 0xFF) << 16 |
            (ord($binary[$offset + 2]) & 0xFF) << 8 |
            (ord($binary[$offset + 3]) & 0xFF)
        ) % pow(10, $digits), $digits, '0', STR_PAD_LEFT);
    }

    /**
     * Verify the code is correct.
     *
     * @param string $code
     * @param string $secret
     * @param int $counter
     * @param int $digits
     * @param OtpAlgorithm $algorithm
     * @return bool
     */
    public static function verify(
        string $code,
        string $secret,
        int $counter,
        int $digits = 6,
        OtpAlgorithm $algorithm = OtpAlgorithm::SHA1
    ): bool {
        return $code === self::getCode($secret, $counter, 0, $digits, $algorithm);
    }
}
