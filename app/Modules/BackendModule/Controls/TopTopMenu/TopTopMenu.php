<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use App\Model\UserBaseLogic;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TopTopMenu extends Control
{

	/** @var \App\Modules\BackendModule\Controls\ISettingsModal */
	public $ISettingsModal;

	/** @var \App\Modules\Backendmodule\Controls\IFeedbackModal */
	public $IFeedbackModal;

	/** @var \App\Modules\BackendModule\Controls\IProfileModal */
	public $IProfileModal;

	/** @var \App\Model\UserBaseLogic */
	public $userBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	public function __construct(IFeedbackModal $IFeedbackModal, IProfileModal $IProfileModal, ISettingsModal $ISettingsModal, UserBaseLogic $userBaseLogic, $loggedUser = NULL)
    {
		$this->IFeedbackModal = $IFeedbackModal;
		$this->IProfileModal = $IProfileModal;
		$this->ISettingsModal = $ISettingsModal;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
    }

	protected function createComponentSettingsModal()
	{
		return $this->ISettingsModal->create($this->loggedUser);
	}

	protected function createComponentProfileModal()
	{
		return $this->IProfileModal->create($this->loggedUser, $this->loggedUser);
	}

	protected function createComponentFeedbackModal()
	{
		return $this->IFeedbackModal->create($this->loggedUser);
	}

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}
}