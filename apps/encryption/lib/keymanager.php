<?php
/**
 * @author Clark Tomlinson  <clark@owncloud.com>
 * @since 2/19/15, 1:20 PM
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\Encryption;


use OC\Encryption\Exceptions\PrivateKeyMissingException;
use OC\Encryption\Exceptions\PublicKeyMissingException;
use OCP\Encryption\IKeyStorage;
use OCP\IConfig;
use OCP\IUser;
use OCP\IUserSession;

class KeyManager {

	/**
	 * @var IKeyStorage
	 */
	private $keyStorage;

	/**
	 * @var Crypt
	 */
	private $crypt;
	/**
	 * @var string
	 */
	private $recoveryKeyId;
	/**
	 * @var string
	 */
	private $publicShareKeyId;
	/**
	 * @var string UserID
	 */
	private $keyId;

	/**
	 * @var string
	 */
	private $publicKeyId = '.public';
	/**
	 * @var string
	 */
	private $privateKeyId = '.private';

	/**
	 * @param IKeyStorage $keyStorage
	 * @param Crypt $crypt
	 * @param IConfig $config
	 * @param IUser $userID
	 */
	public function __construct(IKeyStorage $keyStorage, Crypt $crypt, IConfig $config, IUser $userID) {

		$this->keyStorage = $keyStorage;
		$this->crypt = $crypt;
		$this->recoveryKeyId = $config->getAppValue('encryption', 'recoveryKeyId');
		$this->publicShareKeyId = $config->getAppValue('encryption', 'publicShareKeyId');
		$this->keyId = $userID->getUID();
	}

	/**
	 * @param $userId
	 * @return mixed
	 * @throws PrivateKeyMissingException
	 */
	public function getPrivateKey($userId) {
		$privateKey = $this->keyStorage->getUserKey($userId, $this->privateKeyId);

		if (strlen($privateKey) !== 0) {
			return $privateKey;
		}
		throw new PrivateKeyMissingException();
	}

	/**
	 * @param $userId
	 * @return mixed
	 * @throws PublicKeyMissingException
	 */
	public function getPublicKey($userId) {
		$publicKey = $this->keyStorage->getUserKey($userId, $this->publicKeyId);

		if (strlen($publicKey) !== 0) {
			return $publicKey;
		}
		throw new PublicKeyMissingException();
	}

	/**
	 * @return bool
	 */
	public function recoveryKeyExists() {
		return (strlen($this->keyStorage->getSystemUserKey($this->recoveryKeyId)) !== 0);
	}

	/**
	 * @param $password
	 * @return bool
	 */
	public function checkRecoveryPassword($password) {
		$recoveryKey = $this->keyStorage->getSystemUserKey($this->recoveryKeyId);
		$decryptedRecoveryKey = $this->crypt->decryptPrivateKey($recoveryKey, $password);

		if ($decryptedRecoveryKey) {
			return true;
		}
		return false;
	}

	/**
	 * @param $userId
	 * @param $key
	 * @return bool
	 */
	public function setPublicKey($userId, $key) {
		return $this->keyStorage->setUserKey($userId, $this->publicKeyId, $key);
	}

	/**
	 * @param $userId
	 * @param $key
	 * @return bool
	 */
	public function setPrivateKey($userId, $key) {
		return $this->keyStorage->setUserKey($userId, $this->privateKeyId, $key);
	}

}
