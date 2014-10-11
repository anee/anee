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

		//PROFILE
		$router[] = new Route('<username>', array(
			'module' => 'Backend',
			'presenter' => 'Profile',
			'action' => 'default',
		));

		//SEARCH
		$router[] = new Route('<username>/<presenter>/<action>', array(
			'module' => 'Backend',
			'presenter' => 'Search',
		));

		// SECURITY MODULE
		$security = new RouteList('Security');
		$security[] = new Route('<presenter>/<action>');
		$router[] = $security;

		// BACKEND MODULE
		$router[] = new Route('<username>/<presenter>/<action>', array(
			'module' => 'Backend',
			'presenter' => 'Search',
		));
		$backend = new RouteList('Backend');
		$backend[] = new Route('<username>/<presenter>/<id>', array(
			'presenter' => 'Homepage',
			'id' => NULL,
			'username' => NULL,
			'action' => 'default',
		));
		$backend[] = new Route('<username>/<presenter>/<action>/<id>', array(
			'presenter' => 'Homepage',
			'action' => 'default',
			'id' => NULL,
			'username' => NULL,
		));
		$router[] = $backend;

		return $router;
	}

}
