<?php


namespace App\Modules\BackendModule\Controls;

use App\Model\User;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ITopTopMenu
{

	/**
	 * @param User $loggedUser
	 * @return TopTopMenu
	 */
	function create($loggedUser = NULL);
}