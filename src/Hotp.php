<?php

namespace Mika\Otp;

use Exception;
use Mika\Base32\Base32;

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
}
