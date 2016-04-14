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