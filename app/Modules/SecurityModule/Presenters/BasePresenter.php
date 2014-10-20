<?php

namespace App\Modules\SecurityModule\Presenters;

use Nette;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{
	protected function beforeRender()
	{
		parent::beforeRender();
		$this->setLayout('\..\..\FrontendModule\templates\@layout');
	}
}
