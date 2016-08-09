<?php

namespace App\Modules\SecurityModule\Presenters;



/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{

	/**
	 * @var \App\Modules\BackendModule\Controls\ITopTopMenuFactory
	 * @inject
	 */
	public $ITopTopMenu;

	protected function createComponentTopTopMenu()
	{
		return $this->ITopTopMenu->create();
	}

	public function formatLayoutTemplateFiles()
	{
		return array($this->keeper->getView('Frontend:Base', 'layouts', 'layout'));
	}
}
