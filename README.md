# Pitcher

<img src="https://www.pitcher-app.com/images/Pitcher-Logo-Pos-Big.png" width="400">

Pitcher App (http://www.pitcher-app.com) is a webservice which allows you to easily send exceptions from your project. In contrast to classical monitoring webservices, Pitcher is able to pitch individual exceptions from projects, where Pitcher is acting like a satellite which communicates whith ground control. Register now at pitcher-app.com and create your project. After receiving the secret, the next step is installing the PHP component (or Bundle in case of using Symfony) and linking the satellite by defining the secret.

This PHP component allows you to send notifications through different channels (iOS Push Notification, E-Mail or WAMP Websocket). 

## Integrations

Currently there´s a bundle for Symfony which integrates the component as a service (https://github.com/braune-digital/BrauneDigitalPitcherBundle).

## Installation

Install the package with composer into your project:

```
composer require braune-digital/pitcher "^1.0"
```

## Usage

The BaseClient implements the ClientInterface and allows you to pitch exceptions with GuzzleHTTP to the Pitcher App.

```php
<?php

namespace BrauneDigital\Pitcher\Client;

use Psr\Log\LoggerInterface;

interface ClientInterface {

	/**
	 * @param $level
	 * @param $message
	 * @return mixed
	 */
	public function pitch($level, $message);

	/**
	 * @return mixed
	 */
	public function getLogger();

	/**
	 * @param LoggerInterface $
	 * @return mixed
	 */
	public function setLogger(LoggerInterface $logger);

}
```

You can use this BaseClient and pitch messages:
```php
$client = new \BrauneDigital\Pitcher\Client\BaseClient('SATELLITE_NAME', 'SECRET');
$client->pitch(\BrauneDigital\Pitcher\Notification\Notification::LEVEL_CRITICAL, 'XML API from server B is down');
```

The Pitcher App returns a JSON-Reponse:

```json
{"success":true,"payload":{"level":"critical","message":"XML API from server B is down","date":"2016-04-13T13:23:15+0200","satellite":"YOU_ARE_FREE_TO_CHOOSE_A_NAME","checked":false,"id":141},"errors":[]}
```

Now you will get notifications from the Pitcher app. You can define notification channels in your user profile at http://www.pitcher-app.com/#/login.

