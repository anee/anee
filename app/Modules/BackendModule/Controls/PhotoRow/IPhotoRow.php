<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;
use App\Model\Photo;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IPhotoRow
{

	/**
	 * @param Photo $photo
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @return PhotoRow
	 */
	function create(Photo $photo, User $loggedUser, User $profileUser);
}