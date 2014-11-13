<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IProfile
{

	/**
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @param bool $detail
	 * @return Profile
	 */
	function create(User $loggedUser, User $profileUser, $detail = NULL);
}