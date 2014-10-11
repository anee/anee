<?php

namespace App;

use App\Utils\Arrays;
use Nette;
use	Nette\Application\Routers\RouteList;
use	Nette\Application\Routers\Route;



/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();

		// PROFIL
		$router[] = new Route('<username>', array(
			'module' => 'Backend',
			'presenter' => 'Profile',
			'action' => 'default',
		));

		// SECURITY MODULE
		$router[] = new Route('<presenter>/<action>', array(
			'module' => 'Security',
		));

		// SEARCH
		$router[] = new Route('<username>/<presenter>/<action>', array(
			'module' => 'Backend',
			'presenter' => 'Search',
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
