<?php

namespace App\Modules\SecurityModule\Routes;

use Nette;
use	Nette\Application\Routers\RouteList;
use	Nette\Application\Routers\Route;



/**
 * Router factory.
 */
class SecurityRoutes
{


	/**
	 * @param RouteList $router
	 * @return array|RouteList
	 */
	public static function create(RouteList $router)
	{
		$router[] = new Route('<presenter>/<action>', array(
			'module' => 'Security',
		));

		return $router;
	}

}
