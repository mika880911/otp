# HOTP

HOTP according to [RFC 4226](https://datatracker.ietf.org/doc/html/rfc4226)

## Usage

Generate HOTP information.

```php
<?php

use Mika\Otp\Hotp;
use Mika\Otp\Enums\OtpAlgorithm;

$issuer = 'Example';
$label = 'test@example.com';

$information = Hotp::generate($issuer, $label);

var_dump($information);
```

Verify the code is correct.

```php
<?php

use Mika\Otp\Hotp;
use Mika\Otp\Enums\OtpAlgorithm;

$code = '123456';
$issuer = 'Example';
$label = 'test@example.com';

$information = Hotp::generate($issuer, $label);

$isCorrect = Hotp::verify($code, $information['secret'], $information['counter']);
```
