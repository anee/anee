<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IAddPlaceModal
{

	/**
	 * @param User $loggedUser
	 * @return AddPhotoModal
	 */
	function create(User $loggedUser);
}