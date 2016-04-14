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

	protected $satelliteName;

	protected $url;


	protected $apiVersion;


	/**
	 * @param string $satelliteName
	 * @param string $url
	 * @param string $secret
	 * @param string $apiVersion
	 */
	public function __construct($satelliteName, $url, $secret, $apiVersion) {
		$this->satelliteName = $satelliteName;
		$this->url = $url;
		$this->secret = $secret;
		$this->apiVersion = $apiVersion;
	}


	/**
	 * @param $level
	 * @param $message
	 * @param $satelliteName
	 * @param $url
	 * @param $secret
	 * @param $apiVersion
	 */
	public function pitch($level, $message) {

		$notification = new Notification($level, $message, $this->satelliteName);
		$client = new \GuzzleHttp\Client([
			'base_uri' => $this->url,
			'timeout'  => 3.0,
		]);

		try {
			$response = $client->request('POST', 'api/' . $this->apiVersion . '/pitch', [
				'form_params' => $notification->toArray(),
				'headers' => array(
					'secret' => $this->secret
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