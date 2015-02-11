<?php

namespace App\Modules\ErrorModule\Presenters;

use Nette;


/**
 * Base presenter for all error application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/**
	 * @var \ViewKeeper\ViewKeeper
	 * @inject
	 */
	public $keeper;

	public function formatLayoutTemplateFiles()
	{
		return array($this->keeper->getView('Error:Base', 'layouts', 'layout'));
	}

	public function formatTemplateFiles()
	{
		return array($this->keeper->getView($this->name, 'presenters', '500')); // every time it ll be 500
	}
}

