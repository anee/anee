<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IAddTrackModal
{

	/**
	 * @param User $loggedUser
	 * @return AddTrackModal
	 */
	function create(User $loggedUser);
}