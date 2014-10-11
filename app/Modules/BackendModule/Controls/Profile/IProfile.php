<?php


namespace App\Modules\BackendModule\Controls;
use App\Model\UserBaseLogic;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IProfile
{

	/**
	 * @return /UserPanel
	 */
	function create(UserBaseLogic $userBaseLogic, $username);
}