<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\PlaceBaseLogic;
use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;
use App\Model\Place;
use App\Model\User;


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

    public function __construct(PlaceBaseLogic $placeBaseLogic, UserBaseLogic $userBaseLogic, Place $place, User $loggedUser, User $profileUser)
    {
		$this->place = $place;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
    }

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->place = $this->place;

		$this->template->render();
	}

	public function handleRemove($id)
	{
		$this->placeBaseLogic->remove($id);
		$this->redirect('this');

	}
}