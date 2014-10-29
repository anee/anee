<?php

namespace App\Modules\BackendModule\Routes;

use Nette;
use	Nette\Application\Routers\RouteList;
use	Nette\Application\Routers\Route;



/**
 * Router factory.
 */
class BackendRoutes
{


	/**
	 * @param RouteList $router
	 * @return array|RouteList
	 */
	public static function create(RouteList $router)
	{
		// TRACKS
		/*$router[] = new Route('<username>/<presenter>/<id>', array(
			'module' => 'Backend',
			'action' => 'default',
			'presenter' => 'Tracks',
			'url' => NULL,
		));*/

		// PLACES && TRACKS
		$router[] = new Route('<username>/<presenter>/<url>', array(
			'module' => 'Backend',
			'action' => 'default',
			'presenter' => 'Places',
		));

		// SEARCH
		$router[] = new Route('<username>/<presenter>/<action>', array(
			'module' => 'Backend',
			'presenter' => 'Search',
			'id' => NULL,
		));


		// BACKEND HOMEPAGE ( / )
		$router[] = new Route('<username>/<presenter>/<id>', array(
			'module' => 'Backend',
			'presenter' => 'Homepage',
			'username' => NULL,
			'action' => 'default',
			'id' => NULL,
		));

		return $router;
	}

}
