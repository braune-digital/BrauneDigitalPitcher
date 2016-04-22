<?php

namespace BrauneDigital\Pitcher\Client;

use BrauneDigital\Pitcher\Notification\Notification;
use Psr\Log\LoggerInterface;

class BaseClient implements ClientInterface {

	/**
	 * @var LoggerInterface
	 */
	protected $logger;

	/**
	 * @var string
	 */
	protected $satelliteName;

	/**
	 * @var string
	 */
	protected $url = 'https://api.pitcher-app.com/';

	/**
	 * @var integer
	 */
	protected $apiVersion = 1;


	/**
	 * @param string $satelliteName
	 * @param string $url
	 * @param string $secret
	 * @param string $apiVersion
	 */
	public function __construct($satelliteName, $secret, $apiVersion = null, $url = null) {
		$this->satelliteName = $satelliteName;
		if ($url) {
			$this->url = $url;
		}
		$this->secret = $secret;
		if ($url) {
			$this->apiVersion = $apiVersion;
		}
	}


	/**
	 * @param $level
	 * @param $message
	 */
	public function pitch($level, $message) {

		$notification = new Notification($level, $message, $this->satelliteName);

		try {
			$fields = $notification->toArray();
			$fieldsString = '';
			foreach($fields as $key => $value) {
				$fieldsString .= $key.'='.$value.'&';
			}
			rtrim($fieldsString, '&');

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $this->url . 'api/' . $this->apiVersion . '/pitch');
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fieldsString);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'secret: ' . $this->secret,
			));
			$response = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);

			if (!isset($info['http_code']) || $info['http_code'] != 200) {
				throw new \Exception('Pitcher notification error: ' . $response);
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