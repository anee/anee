<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IUserPanelFactory
{

	/**
	 * @return /UserPanel
	 */
	function create();
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class UserPanel extends Control
{

	/** @var \App\Model\UserBaseLogic */
	public $userBaseLogic;

    public function __construct(UserBaseLogic $userBaseLogic)
    {
		$this->userBaseLogic = $userBaseLogic;
    }

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->user = $this->userBaseLogic->findOneById($this->getPresenter()->getUSer()->id);

		$this->template->render();
	}
}