<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use App\Model\UserBaseLogic;
use App\Model\User;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TopTopMenu extends Control
{

	/** @var \App\Modules\BackendModule\Controls\ISettingsModal @inject */
	public $ISettingsModal;

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	public function __construct(ISettingsModal $ISettingsModal, UserBaseLogic $userBaseLogic, User $loggedUser)
    {
		$this->ISettingsModal = $ISettingsModal;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
    }

	protected function createComponentSettingsModal()
	{
		return $this->ISettingsModal->create($this->loggedUser);
	}

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}
}