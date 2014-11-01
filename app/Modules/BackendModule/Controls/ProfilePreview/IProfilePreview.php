<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IProfilePreview
{

	/**
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @return ProfilePreview
	 */
	function create(User $loggedUser, User $profileUser);
}