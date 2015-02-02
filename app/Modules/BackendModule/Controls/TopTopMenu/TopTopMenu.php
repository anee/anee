<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use App\Model\UserBaseLogic;
use App\Model\User;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ITopTopMenuFactory
{

	/**
	 * @param User $loggedUser
	 * @return TopTopMenu
	 */
	function create($loggedUser = NULL);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TopTopMenu extends Control
{

	/**
	 * @var \App\Modules\BackendModule\Controls\ISettingsModalFactory
	 */
	public $ISettingsModal;

	/**
	 * @var \App\Modules\BackendModule\Controls\IFeedbackModalFactory
	 */
	public $IFeedbackModal;

	/** @var \App\Modules\BackendModule\Controls\IProfileModalFactory
	 */
	public $IProfileModal;

	/**
	 * @var \App\Model\UserBaseLogic
	 * */
	public $userBaseLogic;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

	/**
	 * @var \App\Model\User
	 */
	private $loggedUser;

	public function __construct(ViewKeeper $keeper, IFeedbackModalFactory $IFeedbackModal, IProfileModalFactory $IProfileModal, ISettingsModalFactory $ISettingsModal, UserBaseLogic $userBaseLogic, $loggedUser = NULL)
    {
		$this->keeper = $keeper;
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

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . $this->name, 'controls'));
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}
}