<?php
/**
 * @author Clark Tomlinson  <fallen013@gmail.com>
 * @since 3/6/15, 11:30 AM
 * @link http:/www.clarkt.com
 * @copyright Clark Tomlinson © 2015
 *
 */

namespace OCA\Encryption;


use OCP\ILogger;
use OCP\IUser;

class Setup {
	/**
	 * @var ILogger
	 */
	protected $logger;
	/**
	 * @var IUser
	 */
	protected $user;

	/**
	 * Setup constructor.
	 *
	 * @param ILogger $logger
	 * @param IUser $user
	 */
	public function __construct(ILogger $logger, IUser $user) {
		$this->logger = $logger;
		$this->user = $user;
	}
}
