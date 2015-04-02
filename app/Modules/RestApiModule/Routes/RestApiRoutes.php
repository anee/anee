<?php

namespace App\Modules\FrontendModule\Routes;

use Drahak\Restful\Application\Routes\CrudRoute;
use Nette;
use	Nette\Application\Routers\RouteList;


/**
 * Router factory.
 */
class RestApiRoutes
{

	/**
	 * @param RouteList $router
	 * @return array|RouteList
	 */
	public static function create(RouteList $router)
	{
		$router[] = new CrudRoute('//api.anee.dev/v1/<username>/<presenter>[/<id>[/<relation>[/<relationId>]]]', array(
			'module' => 'RestApi'
		));
		return $router;
	}

}
