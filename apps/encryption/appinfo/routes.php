<?php
/**
 * @author Clark Tomlinson  <clark@owncloud.com>
 * @since 2/19/15, 11:22 AM
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


use OCP\AppFramework\App;

(new App('encryption'))->registerRoutes($this, array('routes' => array(

	[
		'name' => 'recovery#adminRecovery',
		'url' => '/ajax/adminRecovery',
		'verb' => 'POST'
	],
	[
		'name' => 'recovery#userRecovery',
		'url' => '/ajax/userRecovery',
		'verb' => 'POST'
	]


)));
