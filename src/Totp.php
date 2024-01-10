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
}
