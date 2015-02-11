<?php

namespace App\Modules\ErrorModule\Presenters;

use Nette;
use Tracy\Debugger;


/**
 * Error presenter.
 */
class ErrorPresenter extends BasePresenter
{

	/**
	 * @param  Exception
	 * @return void
	 */
	public function renderDefault($exception)
	{
		if ($exception instanceof Nette\Application\BadRequestException) {
			$code = $exception->getCode();
			// load template 403.latte or 404.latte or ... 4xx.latte
			//Debugger::log($this->keeper->getView($this->name, 'presenters', (in_array($code, array(403, 404, 405, 410, 500)) ? $code : '4xx'), NULL));
			//$this->setView($this->keeper->getView($this->name, 'presenters', (in_array($code, array(403, 404, 405, 410, 500)) ? $code : '4xx'), NULL));
			$this->setView($this->getView() . in_array($code, array(403, 404, 405, 410, 500)) ? $code : '4xx');
			// log to access.log
			Debugger::log("HTTP code $code: {$exception->getMessage()} in {$exception->getFile()}:{$exception->getLine()}", 'access');

		} else {
			$this->setView($this->getView() . '500');
			//$this->setView($this->keeper->getView($this->name, 'presenters', '500', NULL));
			Debugger::log($exception, Debugger::ERROR); // and log exception
		}

		if ($this->isAjax()) { // AJAX request? Note this error in payload.
			$this->payload->error = TRUE;
			$this->terminate();
		}
	}

}
