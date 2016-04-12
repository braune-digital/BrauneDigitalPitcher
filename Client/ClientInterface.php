<?php

namespace BrauneDigital\Pitcher\Client;

use Psr\Log\LoggerInterface;

interface ClientInterface {

	/**
	 * @param $level
	 * @param $message
	 * @param $satelliteName
	 * @return mixed
	 */
	public function notify($level, $message, $satelliteName);

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