<?php

namespace App;

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

		//FRONTEND
		$router[] = new Route('<username>', array(
			'module' => 'backend',
			'presenter' => 'Profile',
			'action' => 'default',
		));

		// SECURITY MODULE
		$security = new RouteList('Security');
		$security[] = new Route('<presenter>/<action>');
		$router[] = $security;

		// BACKEND MODULE
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
