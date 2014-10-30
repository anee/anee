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
class SettingsModal extends Control
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

		$form->addText('forename')->setRequired('Please enter your forename.')
			->setAttribute('placeholder', 'Forename');
		$form->addText('surname')->setRequired('Please enter your surname.')
			->setAttribute('placeholder', 'Surname');
		$form->addCheckbox('public');
		$form->addSubmit('save', 'save');
		$form->onSuccess[] = $this->success;

		$form->setDefaults($this->userBaseLogic->findOneByIdArray($this->loggedUser->id)[0]);

		return $form;
	}

	public function success($form)
	{
		$values = $form->getValues();

		if ($this->getPresenter()->isAjax()) {
			$user = $this->loggedUser;

			$user->public = $values['public'];
			$user->surname = $values['surname'];
			$user->forename = $values['forename'];

			$this->userBaseLogic->save($user);

			$this->getPresenter()->redirect('this');
		}
	}
}