<?php

namespace BrauneDigital\Pitcher\Notification;

class Notification implements NotificationInterface {

	const LEVEL_OKAY = 'okay';
	const LEVEL_DEBUG = 'debug';
	const LEVEL_INFO = 'info';
	const LEVEL_ERROR = 'error';
	const LEVEL_CRITICAL = 'critical';

	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var string
	 */
	protected $level;

	/**
	 * @var string
	 */
	protected $satelliteName;

	/**
	 * @param $level
	 * @param $message
	 * @param $satelliteName
	 */
	public function __construct($level, $message, $satelliteName) {
		$this->message = $message;
		$this->level = $level;
		$this->satelliteName = $satelliteName;
	}

	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}

	/**
	 * @return string
	 */
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * @param string $level
	 */
	public function setLevel($level)
	{
		$this->level = $level;
	}

	/**
	 * @return string
	 */
	public function getSatelliteName()
	{
		return $this->satelliteName;
	}

	/**
	 * @param string $satelliteName
	 */
	public function setSatelliteName($satelliteName)
	{
		$this->satelliteName = $satelliteName;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return array(
			'satellite' => $this->getSatelliteName(),
			'message' => $this->getMessage(),
			'level' => $this->getLevel(),
		);
	}

}