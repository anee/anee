<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\Place;
use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IPlaceRow
{

	/**
	 * @param Place $place
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @param bool $detail
	 * @return PlaceRow
	 */
	function create(Place $place, User $loggedUser, User $profileUser, $detail = NULL);
}