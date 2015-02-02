<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;
use ViewKeeper\ViewKeeper;

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

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

	/**
	 * @var \App\Model\UserBaseLogic
	 */
	public $userBaseLogic;

    public function __construct(ViewKeeper $keeper, UserBaseLogic $userBaseLogic)
    {
		$this->keeper = $keeper;
		$this->userBaseLogic = $userBaseLogic;
    }

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . $this->name, 'controls'));

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->user = $this->userBaseLogic->findOneById($this->getPresenter()->getUSer()->id);

		$this->template->render();
	}
}