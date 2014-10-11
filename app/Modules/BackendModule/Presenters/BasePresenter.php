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

	/** @var \App\Modules\BackendModule\Controls\IUserPanel @inject */
	public $IUserPanel;

	protected function createComponentSearchFor()
	{
		return $this->ISearchFor->create();
	}

	protected function createComponentUserPanel()
	{
		return $this->IUserPanel->create();
	}

	protected function createTemplate($class = NULL)
	{
		$template = parent::createTemplate($class);

		// HELPERS
		$template->addFilter(NULL, 'App\TemplateHelpers::loader');
		$template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

		return $template;
	}

	protected function beforeRender()
	{
		parent::beforeRender();

		if($this->user->isLoggedIn()) {
			$this->setLayout('layoutBackend');
		}
	}
}
