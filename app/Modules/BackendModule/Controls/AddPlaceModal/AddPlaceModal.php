<?php

namespace App\Modules\BackendModule\Controls;

use Nette\Application\UI\Control;
use App\Model\UserBaseLogic;
use App\Model\PlaceBaseLogic;
use Nette\Application\UI\Form;
use App\Model\User;
use App\Model\Place;
use ViewKeeper\ViewKeeper;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IAddPlaceModalFactory
{

	/**
	 * @param User $loggedUser
	 * @return AddPhotoModal
	 */
	function create(User $loggedUser);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddPlaceModal extends Control
{

	/**
	 * @var UserBaseLogic
	 */
	public $userBaseLogic;

	/**
	 * @var PlaceBaseLogic
	 */
	public $placeBaseLogic;

	/**
	 * @var User
	 */
	private $loggedUser;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

	public function __construct(User $loggedUser, ViewKeeper $keeper, PlaceBaseLogic $placeBaseLogic, UserBaseLogic $userBaseLogic)
	{
		$this->keeper = $keeper;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
	}

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'AddPlaceModal', 'controls'));
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}

	protected function createComponentAddPlaceForm()
	{

        $placeNameValidator = function($textInput) {
            return !$this->placeBaseLogic->findOneByNameAndUserName($textInput->value, $this->loggedUser->getUsername());
        };

		$form = new Form;
		$form->addText('name')
            ->setRequired('You have no filled place name.')
			->setAttribute('placeholder', 'Place name')
            ->addRule($placeNameValidator, 'You have filled already existing place name');
		$form->addSubmit('save', 'add');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success(Form $form)
	{
		if ($this->getPresenter()->isAjax()) {
			$values = $form->getValues();

			/** Check if not exist */
			$place = $this->placeBaseLogic->findOneByNameAndUserName($values->name, $this->loggedUser->username);

			/** Create new place */
			if ($place == NULL) {
				$user = $this->loggedUser;

				$place = new Place($values->name, $user);
				$this->placeBaseLogic->save($place);
			} else {
				$form->addError('Place with this name already exist.');
			}

            $this->getPresenter()->redirect('this');
		}
	}
}