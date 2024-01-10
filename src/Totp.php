<?php

namespace Mika\Otp;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Mika\Otp\Enums\OtpAlgorithm;

class Totp
{
    /**
     * Generate Totp information.
     *
     * @param string $issuer
     * @param string $label
     * @param int $digits
     * @param int $period
     * @param int $secretLength
     * @param OtpAlgorithm $algorithm
     * @return array
     * @throws Exception
     */
    #[ArrayShape([
        'secret' => "string",
        'url' => "string"
    ])]
    public static function generate(
        string $issuer,
        string $label,
        int $digits = 6,
        int $period = 30,
        int $secretLength = 20,
        OtpAlgorithm $algorithm = OtpAlgorithm::SHA1
    ): array {
        $secret = Otp::generateSecret($secretLength);

        return [
            'secret' => $secret,
            'url' => "otpauth://totp/{$label}?secret={$secret}&issuer={$issuer}&algorithm={$algorithm->value}&digits={$digits}&period={$period}"
        ];
    }

    /**
     * Verify the code is correct.
     *
     * @param string $code
     * @param string $secret
     * @param int $period
     * @param int $digits
     * @param OtpAlgorithm $algorithm
     * @return bool
     */
    public static function verify(
        string $code,
        string $secret,
        int $period = 30,
        int $digits = 6,
        OtpAlgorithm $algorithm = OtpAlgorithm::SHA1
    ): bool {
        for ($i = -1; $i < 2; $i++) {
            if ($code === Otp::getCode($secret, floor(time() / $period) + $i, $digits, $algorithm)) {
                return true;
            }
        }

        return false;
    }
}
