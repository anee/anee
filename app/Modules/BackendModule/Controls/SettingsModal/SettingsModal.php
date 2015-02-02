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
interface ISettingsModal
{

	/**
	 * @param User $loggedUser
	 * @return SettingsModal
	 */
	function create(User $loggedUser);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SettingsModal extends Control
{

	/** @var \App\Model\UserBaseLogic */
	public $userBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	private $appDir;

	public function __construct(UserBaseLogic $userBaseLogic, User $loggedUser, $appDir)
	{
		$this->appDir = $appDir;
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
		$form->addUpload('profileImage');
		$form->addUpload('backgroundImage');
		$form->addSubmit('save', 'save');
		$form->onSuccess[] = $this->success;

		$form->setDefaults($this->userBaseLogic->findOneByIdArray($this->loggedUser->id)[0]);

		return $form;
	}

	public function success($form)
	{
		if ($this->getPresenter()->isAjax()) {
			$values = $form->getValues();
			$user = $this->loggedUser;

			$filename = null;
			$filePath = null;
			if ($values->profileImage->getSanitizedName() != null) {
				if ($values->profileImage->isOk()) {
					$filename = $values->profileImage->getSanitizedName();
					$filePath = $this->appDir."/data/users/".$this->loggedUser->id."/images/$filename";
					$values->profileImage->move($filePath);
					$user->profileImage = $filename;
				}
			}
			$filename = null;
			$filePath = null;
			if ($values->backgroundImage->getSanitizedName() != null) {
				if ($values->backgroundImage->isOk()) {
					$filename = $values->backgroundImage->getSanitizedName();
					$filePath = $this->appDir."/data/users/".$this->loggedUser->id."/images/$filename";
					$values->backgroundImage->move($filePath);
					$user->backgroundImage = $filename;
				}
			}
			$user->public = $values['public'];
			$user->surname = $values['surname'];
			$user->forename = $values['forename'];

			$this->userBaseLogic->save($user);

			$this->getPresenter()->redirect('this');
		}
	}

	public function handleRemoveProfileImage()
	{
		if ($this->getPresenter()->isAjax()) {
			$user = $this->loggedUser->setProfileImage(NULL);
			$this->userBaseLogic->save($user);

			$this->getPresenter()->redirect('this');
		}
	}

	public function handleRemoveBackgroundImage()
	{
		if ($this->getPresenter()->isAjax()) {
			$user = $this->loggedUser->setBackgroundImage(NULL);
			$this->userBaseLogic->save($user);

			$this->getPresenter()->redirect('this');
		}
	}
}