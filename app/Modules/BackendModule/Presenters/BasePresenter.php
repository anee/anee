<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;
use App\Modules\BackendModule\Forms\TInjectSearchFormFactory;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{

	/** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
	public $thumbnailsHelper;

	/** @var \App\Modules\BackendModule\Controls\ISearchFor @inject */
	public $ISearchFor;

	protected function createComponentSearchFor()
	{
		return $this->ISearchFor->create();
	}

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

		if($this->user->isLoggedIn()) {
			dump($this->getUser());
			die();
			$files[] = __DIR__ . '/../templates/@layoutBackend.latte';
		}
		return $files;
	}

	/*public function checkRequirements($element)
	{
		parent::checkRequirements($element);

		if (!$this->user->isLoggedIn()) {
			$this->redirect(':Backend:Homepage:default');
		}
	}*/
}
