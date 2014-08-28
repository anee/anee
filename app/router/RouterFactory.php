<?php

namespace App;

use Nette;
use	Nette\Application\Routers\RouteList;
use	Nette\Application\Routers\Route;
use	Nette\Application\Routers\SimpleRouter;


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

        // DEFAULT
        $router[] = new Route('<presenter>/<action>/<id>', array(
            'module' => 'Front',
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => NULL,
        ));

		return $router;
	}

}