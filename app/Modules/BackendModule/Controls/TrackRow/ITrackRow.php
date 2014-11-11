<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;
use App\Model\Track;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ITrackRow
{

	/**
	 * @param Track $track
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @param string $byName
	 * @return TrackRow
	 */
	function create(Track $track, User $loggedUser, User $profileUser, $byName = NULL);
}