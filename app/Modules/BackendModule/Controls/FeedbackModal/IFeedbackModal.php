<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IFeedbackModal
{

	/**
	 * @param User $loggedUser
	 * @return FeedbackModal
	 */
	function create(User $loggedUser);
}