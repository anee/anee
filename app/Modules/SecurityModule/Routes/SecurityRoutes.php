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
		$router[] = new Route('Register/In', array(
			'module' => 'Security',
			'presenter' => 'Register',
			'action' => 'in',
		));
		$router[] = new Route('Sign/In', array(
			'module' => 'Security',
			'presenter' => 'Sign',
			'action' => 'in',
		));

		$router[] = new Route('Sign/Out', array(
			'module' => 'Security',
			'presenter' => 'Sign',
			'action' => 'out',
		));

		$router[] = new Route('Account/Remove', array(
			'module' => 'Security',
			'presenter' => 'Account',
			'action' => 'remove',
		));

		return $router;
	}

}
