<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ISettingsModal
{

	/**
	 * @param User $loggedUser
	 * @return SettingsModal
	 */
	function create(User $loggedUser);
}