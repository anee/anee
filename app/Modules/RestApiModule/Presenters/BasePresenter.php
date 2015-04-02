<?php


namespace App\Modules\RestApiModule\Presenters;
use Drahak\Restful\Application\UI\ResourcePresenter;

/**
 * Class BasePresenter
 *
 * @author Lukáš Drahník <http://drahnik-lukas.com/>
 */
class BasePresenter extends ResourcePresenter {


	protected function setError($message = 'Result has not been found.', $type = '404')
	{
		$this->resource->error = $type;
		$this->resource->error_description = $message;
	}
}