# TOTP

TOTP according to [RFC 6238](https://datatracker.ietf.org/doc/html/rfc6238).

## Usage

Generate TOTP information.

```php
<?php

use Mika\Otp\Totp;
use Mika\Otp\Enums\OtpAlgorithm;

$issuer = 'Example';
$label = 'test@example.com';

$information = Totp::generate($issuer, $label);

var_dump($information);
```

Verify the code is correct.

```php
<?php

use Mika\Otp\Totp;
use Mika\Otp\Enums\OtpAlgorithm;

$code = '123456';
$issuer = 'Example';
$label = 'test@example.com';

$information = Totp::generate($issuer, $label);

$isCorrect = Totp::verify($code, $information['secret']);
```
