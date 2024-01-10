<?php

namespace Mika\Otp\Enums;

enum OtpAlgorithm: string
{
    case SHA1 = 'SHA1';
    case SHA256 = 'SHA256';
    case SHA512 = 'SHA512';
}
