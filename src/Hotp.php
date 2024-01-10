<?php

namespace Mika\Otp;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Mika\Otp\Enums\OtpAlgorithm;

class Hotp
{
    /**
     * Generate HOTP information.
     *
     * @param string $issuer
     * @param string $label
     * @param int $digits
     * @param int $counter
     * @param int $secretLength
     * @param OtpAlgorithm $algorithm
     * @return array
     * @throws Exception
     */
    #[ArrayShape([
        'secret' => "string",
        'counter' => "int",
        'url' => "string"
    ])]
    public static function generate(
        string $issuer,
        string $label,
        int $digits = 6,
        int $counter = 0,
        int $secretLength = 20,
        OtpAlgorithm $algorithm = OtpAlgorithm::SHA1
    ): array {
        $secret = Otp::generateSecret($secretLength);

        return [
            'secret' => $secret,
            'counter' => $counter,
            'url' => "otpauth://hotp/{$label}?secret={$secret}&issuer={$issuer}&algorithm={$algorithm->value}&digits={$digits}&counter={$counter}"
        ];
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
        return $code === Otp::getCode($secret, $counter, $digits, $algorithm);
    }
}
