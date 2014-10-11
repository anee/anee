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

    public function __construct(UserBaseLogic $userBaseLogic)
    {
		$this->userBaseLogic = $userBaseLogic;
    }

	public function render()
	{
		$this->template->setFile(__DIR__ . '/UserPanel.latte');

		$this->template->user = $this->userBaseLogic->findOneByUsername($this->getPresenter()->user->getIdentity()->data['username']);

		$this->template->render();
	}
}