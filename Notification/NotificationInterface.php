<?php

namespace BrauneDigital\Pitcher\Notification;

interface NotificationInterface {

	/**
	 * @return mixed
	 */
	public function getMessage();

	/**
	 * @param $message
	 * @return mixed
	 */
	public function setMessage($message);

	/**
	 * @return mixed
	 */
	public function getLevel();

	/**
	 * @param $level
	 * @return mixed
	 */
	public function setLevel($level);

	/**
	 * @return mixed
	 */
	public function getSatelliteName();

	/**
	 * @param string $satellite
	 * @return mixed
	 */
	public function setSatelliteName($satellite);

}