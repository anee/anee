<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;


/**
 * Base presenter for all front application presenters.
 */
abstract class BasePresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{

	/** @var \App\Modules\BackendModule\Controls\ITopMenu @inject */
	public $ITopMenu;

	/** @var \App\Modules\BackendModule\Controls\ITopTopMenu @inject */
	public $ITopTopMenu;

	/** @var \App\Modules\BackendModule\Controls\IUserPanel @inject */
	public $IUserPanel;

	/** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
	public $thumbnailsHelper;

	/** @var \App\Model\UserBaseLogic @inject */
	public $userBaseLogic;

	protected function createComponentTopMenu()
	{
		return $this->ITopMenu->create();
	}

	protected function createComponentTopTopMenu()
	{
		return $this->ITopTopMenu->create($this->userBaseLogic->findOneById($this->getUser()->id));
	}

	protected function createComponentUserPanel()
	{
		return $this->IUserPanel->create();
	}

	public function formatLayoutTemplateFiles()
	{
		if(!$this->getUser()->isLoggedIn()) {
			$themeDir = $this->theme->getParameter('themeDir');
			return [$themeDir . '/Modules/Frontend/templates/@layout.latte'];
		} else {
			return $this->theme->getFormatLayoutTemplateFiles();
		}
	}
}
