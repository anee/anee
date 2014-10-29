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
	 * @param User $user
	 * @return Profile
	 */
	function create(User $loggedUser, User $user);
}