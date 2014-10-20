<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class UserPanel extends Control
{

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

	/** @var \App\Modules\BackendModule\Controls\IUserPanelAdd @inject */
	public $IUserPanelAdd;


    public function __construct(UserBaseLogic $userBaseLogic, IUserPanelAdd $IUserPanelAdd)
    {
		$this->userBaseLogic = $userBaseLogic;
		$this->IUserPanelAdd = $IUserPanelAdd;
    }

	protected function createComponentUserPanelAdd()
	{
		return $this->IUserPanelAdd->create();
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/UserPanel.latte');
		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->user = $this->userBaseLogic->findOneByUsername($this->getPresenter()->user->getIdentity()->data['username']);

		$this->template->render();
	}
}