<?php

namespace BrauneDigital\Pitcher\Client;

use BrauneDigital\Pitcher\Notification\Notification;
use GuzzleHttp\Exception\ConnectException;
use Psr\Log\LoggerInterface;

class BaseClient implements ClientInterface {

	/**
	 * @var LoggerInterface
	 */
	protected $logger;


	/**
	 * @param $level
	 * @param $message
	 * @param $satelliteName
	 * @param $url
	 * @param $secret
	 * @param $apiVersion
	 */
	public function pitch($level, $message, $satelliteName, $url, $secret, $apiVersion) {

		$notification = new Notification($level, $message, $satelliteName);
		$client = new \GuzzleHttp\Client([
			'base_uri' => $url,
			'timeout'  => 3.0,
		]);

		try {
			$response = $client->request('POST', 'api/' . $apiVersion . '/pitch', [
				'form_params' => $notification->toArray(),
				'headers' => array(
					'secret' => $secret
				)
			]);
			if ($response->getStatusCode() != 200) {
				$this->logger->error('Pitcher notification error: ' . $response->getBody());
			}
		} catch (\Exception $e) {
			$this->logger->error('Pitcher notification exception: ' . $e->getMessage());
		}
	}

	/**
	 * @return LoggerInterface
	 */
	public function getLogger()
	{
		return $this->logger;
	}

	/**
	 * @param LoggerInterface $logger
	 */
	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

}