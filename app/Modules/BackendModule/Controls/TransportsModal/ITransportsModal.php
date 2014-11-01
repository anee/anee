<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ITransportsModal
{

	/**
	 * @param User $profileUser
	 * @param User $loggedUser
	 * @return TransportsModal
	 */
	function create(User $profileUser, User $loggedUser);
}