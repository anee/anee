<?php

namespace App;


use App\Modules\FrontendModule\Routes\RestApiRoutes;
use Nette;
use	Nette\Application\Routers\RouteList;
use App\Modules\SecurityModule\Routes\SecurityRoutes;
use App\Modules\BackendModule\Routes\BackendRoutes;
use App\Modules\FrontendModule\Routes\FrontendRoutes;

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

		$router = RestApiRoutes::create($router);
		$router = FrontendRoutes::create($router);
		$router = SecurityRoutes::create($router);
		$router = BackendRoutes::create($router);

		return $router;
	}

}
