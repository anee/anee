<?php

namespace App\Modules\FrontendModule\Routes;

use Nette;
use	Nette\Application\Routers\RouteList;
use	Nette\Application\Routers\Route;



/**
 * Router factory.
 */
class FrontendRoutes
{


	/**
	 * @param RouteList $router
	 * @return array|RouteList
	 */
	public static function create(RouteList $router)
	{

		// PROFIL
		$router[] = new Route('<username>', array(
			'module' => 'Backend',
			'presenter' => 'Profile',
			'action' => 'default',
		));

		return $router;
	}

}
