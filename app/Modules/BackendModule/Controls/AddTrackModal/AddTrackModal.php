<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use App\Model\UserBaseLogic;
use Nette\Application\UI\Form;
use App\Model\User;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddTrackModal extends Control
{

	/** @var \App\Model\UserBaseLogic @inject */
	public $userBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;


	public function __construct(UserBaseLogic $userBaseLogic, User $loggedUser)
	{
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
	}

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}

	protected function createComponentSettingsForm()
	{
		$form = new Form;


		$form->addSubmit('save', 'save');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success($form)
	{
		if ($this->getPresenter()->isAjax()) {
			$values = $form->getValues();

			$this->getPresenter()->redirect('this');
		}
	}
}