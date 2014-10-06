<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{

	/** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
	public $thumbnailsHelper;


	protected function createTemplate($class = NULL)
	{
		$template = parent::createTemplate($class);

		// HELPERS
		$template->addFilter(NULL, 'App\TemplateHelpers::loader');
		$template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

		return $template;
	}

	public function formatLayoutTemplateFiles()
	{
		$files = parent::formatLayoutTemplateFiles();
		$files[] = __DIR__ . '/../templates/@layout.latte';

		return $files;
	}

	public function checkRequirements($element)
	{
		parent::checkRequirements($element);

		if (!$this->user->isLoggedIn()) {
			$this->redirect(':Security:Sign:in');
		}
	}
}
