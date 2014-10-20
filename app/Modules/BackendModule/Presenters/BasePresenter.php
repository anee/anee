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

	/** @var \App\Modules\BackendModule\Controls\ITopMenu @inject */
	public $ITopMenu;

	/** @var \App\Modules\BackendModule\Controls\ITopTopMenu @inject */
	public $ITopTopMenu;

	/** @var \App\Modules\BackendModule\Controls\IUserPanel @inject */
	public $IUserPanel;

	protected function createComponentTopMenu()
	{
		return $this->ITopMenu->create();
	}

	protected function createComponentTopTopMenu()
	{
		return $this->ITopTopMenu->create();
	}

	protected function createComponentUserPanel()
	{
		return $this->IUserPanel->create();
	}

	protected function createTemplate($class = NULL)
	{
		$template = parent::createTemplate($class);

		$template->addFilter(NULL, 'App\TemplateHelpers::loader');
		$template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

		return $template;
	}

	protected function beforeRender()
	{
		parent::beforeRender();

		if(!$this->user->isLoggedIn()) {
			$this->setLayout('\..\..\FrontendModule\templates\@layout');
		}
	}
}
