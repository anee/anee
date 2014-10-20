<?php

namespace App\Modules\SecurityModule\Presenters;

use Nette;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{

	public function formatLayoutTemplateFiles()
	{
		$themeDir = $this->theme->getParameter('themeDir');
		return [$themeDir . '/Modules/Frontend/templates/@layout.latte'];
	}
}
