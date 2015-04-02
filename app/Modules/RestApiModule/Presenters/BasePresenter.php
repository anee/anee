<?php


namespace App\Modules\RestApiModule\Presenters;
use Drahak\Restful\Application\UI\ResourcePresenter;

/**
 * Class BasePresenter
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class BasePresenter extends ResourcePresenter {


	/** @var \App\Model\UserFacade @inject */
	public $userFacade;

	protected function setError($message = 'Result has not been found.', $type = '404')
	{
		$this->resource->error = $type;
		$this->resource->error_description = $message;
	}
}