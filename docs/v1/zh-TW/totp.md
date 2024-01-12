# TOTP

基於 [RFC 6238](https://datatracker.ietf.org/doc/html/rfc6238) 的 TOTP

## Usage

生成 TOTP 資訊

```php
<?php

use Mika\Otp\Totp;
use Mika\Otp\Enums\OtpAlgorithm;

$issuer = 'Example';
$label = 'test@example.com';

$information = Totp::generate($issuer, $label);

var_dump($information);
```

檢查驗證碼是否正確

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
