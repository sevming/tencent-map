<h1 align="center"> tencent-map </h1>

## Requirement   
1. PHP >= 7.2
2. [Composer](https://getcomposer.org/)


## Installing

```shell
$ composer require sevming/tencent-map -vvv
```

## Usage
```php
<?php

use Sevming\TencentMap\TencentMap;

$aliyun = new TencentMap([
    'key' => '',
]);
$aliyun->getLocationByIp();
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/sevming/tencent-map/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/sevming/tencent-map/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT