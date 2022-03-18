# Piges Security
[![Total Downloads](https://poser.pugx.org/piges/security/downloads)](https://packagist.org/packages/piges/security)
[![License](https://poser.pugx.org/piges/security/license)](https://packagist.org/packages/piges/security)
[![Latest Stable Version](https://poser.pugx.org/piges/security/v/stable)](https://packagist.org/packages/piges/security)

Library for use security funcionality of piges PaaS

## Installation

``` bash
composer require piges/security
```

## Usage

Use autentication 

``` php
<?php

use Piges\Auth\AuthFilter;
use Piges\Auth\AuthenticationHolder;

try {
	AuthFilter::filter();

	$user = Array(
		'id' => AuthenticationHolder::getAuthentication()->getId(),
		'authorities' => AuthenticationHolder::getAuthentication()->getAuthorities()
	);
} catch (\Throwable $th) {
	echo "Error in authentication: " + $th->getMessage();
}

```

Use UCP 

``` php
<?php

use Piges\Auth\AuthFilter;
use Piges\Ucp\UcpFilter;
use Piges\Ucp\UcpHolder;

try {
	AuthFilter::filter();

	UcpFilter::filter();

	$user = Array(
		'tenant' => UcpHolder::getUcp()->getTenant()->getName(),
		'eopoos' => UcpHolder::getUcp()->getEopoos(),
		'permissions' => UcpHolder::getUcp()->getPermissions()
	);
} catch (\Throwable $th) {
	echo "Error in authentication or in ucp: " + $th->getMessage();
}
```

## License

[MIT](LICENSE)
