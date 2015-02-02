<?php

namespace App\Modules\SecurityModule\Presenters;

use Nette;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{

	/** @var \App\Modules\BackendModule\Controls\ITopTopMenuFactory @inject */
	public $ITopTopMenu;

	protected function createComponentTopTopMenu()
	{
		return $this->ITopTopMenu->create();
	}

	public function formatLayoutTemplateFiles()
	{
		$themeDir = $this->theme->getParameter('themeDir');
		return [$themeDir . '/Modules/Frontend/templates/@layout.latte'];
	}
}
