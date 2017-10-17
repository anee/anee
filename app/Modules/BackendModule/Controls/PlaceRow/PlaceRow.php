<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\PlaceBaseLogic;
use App\Model\Track;
use App\Model\TrackBaseLogic;
use App\Model\UserBaseLogic;
use Kdyby\Doctrine\DuplicateEntryException;
use Nette;
use Nette\Application\UI\Control;
use App\Model\Place;
use App\Model\User;
use Nette\Application\UI\Form;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IPlaceRowFactory
{

	/**
	 * @param Place $place
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @param bool $detail
	 * @return PlaceRow
	 */
	function create(Place $place, User $loggedUser, User $profileUser, $detail = NULL);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlaceRow extends Control
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
     * @var TrackBaseLogic
     */
    public $trackBaseLogic;

    /**
	 * @var User
	 */
	private $loggedUser;

	/**
	 * @var User
	 */
	private $profileUser;

	/**
	 * @var Place
	 */
	private $place;

	private $detail;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

    public function __construct(Place $place, User $loggedUser = NULL, User $profileUser, $detail = NULL, ViewKeeper $keeper, PlaceBaseLogic $placeBaseLogic, UserBaseLogic $userBaseLogic, TrackBaseLogic $trackBaseLogic)
    {
		$this->keeper = $keeper;
		$this->place = $place;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
		$this->detail = $detail;
    }

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'PlaceRow', 'controls'));

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$filteredTracks = $this->trackBaseLogic->findAllByUserIdAndPlace($this->profileUser->getId(), $this->place);
		$placeDistance = 0;
		$placeTimeInSeconds = 0;
		foreach ($filteredTracks as $track) {
		    /** @var Track $track */
            $placeDistance += $track->getDistance();
            $placeTimeInSeconds += $track->getTimeInSeconds();
        }
        $this->template->placeTimeInSeconds = $placeTimeInSeconds;
		$this->template->placeDistance = $placeDistance;
        $this->template->placeTracks = $filteredTracks;

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
			->setAttribute('placeholder', 'Name')
			->setDefaultValue($this->place->name);
		$form->addSubmit('save', 'save changes');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success($form)
	{
		if ($this->getPresenter()->isAjax()) {
			/** Change name, so also need change nameUrl */
			$place = $this->place;
			$place->setName($form->getValues()->name);
			try {
				$this->placeBaseLogic->save($place);
			} catch (DuplicateEntryException $e) {
				$this->redirect('this');
			}
			$this->getPresenter()->redirect(':Backend:Places:default', array('username' => $this->loggedUser->usernameUrl, 'url' => $place->getUrl()));
		}
	}
}