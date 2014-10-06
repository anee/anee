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

		$backend = new RouteList('Backend');
		$backend[] = new Route('user/<username>/<presenter>/<action>/<id>', array(
			'username' => NULL,
			'presenter' => 'Homepage',
			'action' => 'default',
			'id' => NULL,
		));
		$router[] = $backend;

		$router[] = new Route('<module>/<presenter>/<action>', array(
			'module' => 'Frontend',
			'presenter' => 'Homepage',
			'action' => 'default',
		));

		return $router;
	}

}
