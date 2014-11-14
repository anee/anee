<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use App\Model\UserBaseLogic;
use App\Model\PlaceBaseLogic;
use Nette\Application\UI\Form;
use App\Model\User;
use App\Model\Place;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddPlaceModal extends Control
{

	/** @var UserBaseLogic */
	public $userBaseLogic;

	/** @var PlaceBaseLogic */
	public $placeBaseLogic;

	/** @var User */
	private $loggedUser;

	public function __construct(PlaceBaseLogic $placeBaseLogic, UserBaseLogic $userBaseLogic, User $loggedUser)
	{
		$this->placeBaseLogic = $placeBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
	}

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}

	protected function createComponentAddPlaceForm()
	{
		$form = new Form;
		$form->addText('name')->setRequired('You have no filled place name.')
			->setAttribute('placeholder', 'Place name');
		$form->addSubmit('save', 'save');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success($form)
	{
		if ($this->getPresenter()->isAjax()) {
			$values = $form->getValues();

			/** Check if not exist */
			$place = $this->placeBaseLogic->findOneByNameAndUserName($values->name, $user->username);


			/** Create new place */
			if ($place == NULL) {
				$user = $this->loggedUser;

				$place = new Place($values->name, $user);
				$this->placeBaseLogic->save($place);

				$this->getPresenter()->redirect('this');
			} else {
				$form->addError('Place with this name already exist.');
			}
		}
	}
}