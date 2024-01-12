# HOTP

基於 [RFC 4226](https://datatracker.ietf.org/doc/html/rfc4226) 的 HOTP

## Usage

生成 HOTP 資訊

```php
<?php

use Mika\Otp\Hotp;
use Mika\Otp\Enums\OtpAlgorithm;

$issuer = 'Example';
$label = 'test@example.com';

$information = Hotp::generate($issuer, $label);

var_dump($information);
```

檢查驗證碼是否正確

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
