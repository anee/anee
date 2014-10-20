<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class UserPanelAdd extends Control
{

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

    public function __construct(UserBaseLogic $userBaseLogic)
    {
		$this->userBaseLogic = $userBaseLogic;
    }

	public function render()
	{
		$this->template->setFile(__DIR__ . '/UserPanelAdd.latte');
		$this->template->render();
	}
}