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
	 */
	public function notify($level, $message, $satelliteName) {
		$notification = new Notification($level, $message, $this->container->getParameter('braune_digital_pitcher.satellite_name'));

		$client = new \GuzzleHttp\Client([
			'base_uri' => $this->container->getParameter('braune_digital_pitcher')['pitcher_url'],
			'timeout'  => 3.0,
		]);

		try {
			$response = $client->request('POST', '/api/' . $this->container->getParameter('braune_digital_pitcher')['api_version'] . '/notify', [
				'form_params' => array_merge($notification->toArray(), array(
					'secret' => $this->container->getParameter('braune_digital_pitcher')['secret']
				))
			]);
		} catch (ConnectException $e) {
			$this->logger->error($e->getMessage());
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