<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\PlaceBaseLogic;
use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;
use App\Model\Place;
use App\Model\User;
use Nette\Forms\Form;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlaceRow extends Control
{

	/** @var UserBaseLogic */
	public $userBaseLogic;

	/** @var PlaceBaseLogic */
	public $placeBaseLogic;

	/** @var User */
	private $loggedUser;

	/** @var User */
	private $profileUser;

	/** @var Place */
	private $place;

	private $detail;

    public function __construct(PlaceBaseLogic $placeBaseLogic, UserBaseLogic $userBaseLogic, Place $place, User $loggedUser, User $profileUser, $detail = NULL)
    {
		$this->place = $place;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
		$this->detail = $detail;
    }

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->place = $this->place;
		$this->template->detail = $this->detail;

		$this->template->render();
	}

	public function handleRemove($id)
	{
		if ($this->getPresenter()->isAjax()) {
			$this->placeBaseLogic->remove($id);

			$this->redirect('this');
		}
	}

	protected function createComponentPlaceEditForm()
	{
		$form = new Form;

		$form->addText('name')->setRequired('Place name is not valid.')
			->setAttribute('placeholder', 'Place name')
			->setDefaultValue($this->place->name);
		$form->addSubmit('save', 'save');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success($form)
	{
		if ($this->getPresenter()->isAjax()) {
			/** Change name, so also need change nameUrl */
			$place = $this->place;
			$place->setName($form->getValues()->name);
			$this->placeBaseLogic->save($place);

			//$this->redirect('this');
		}
	}
}