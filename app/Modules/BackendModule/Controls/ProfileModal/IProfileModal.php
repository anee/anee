<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IProfileModal
{

	/**
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @return ProfileModal
	 */
	function create(User $loggedUser, User $profileUser);
}