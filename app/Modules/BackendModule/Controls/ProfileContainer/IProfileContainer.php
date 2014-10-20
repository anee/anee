<?php


namespace App\Modules\BackendModule\Controls;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IProfileContainer
{

	/**
	 * @param $username
	 * @return Profile
	 */
	function create($username);
}