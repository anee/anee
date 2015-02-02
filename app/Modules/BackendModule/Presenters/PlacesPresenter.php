<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlacesPresenter extends BasePresenter
{

	/** @var \App\Model\PlaceBaseLogic @inject */
	public $placeBaseLogic;

	/** @var \App\Model\Place */
	public $place;

	/** @var \App\Modules\BackendModule\Controls\IProfileFactory @inject */
	public $IProfile;

	/** @var \App\Modules\BackendModule\Controls\IPlaceRowFactory @inject */
	public $IPlaceRow;

	private $username;

	private $user;

	/**
	 * @param $username
	 * @param $url = id
	 * @throws Nette\Application\BadRequestException
	 */
	public function actionDefault($username, $url)
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($username);
		$place = $this->placeBaseLogic->findOneByNameUrlAndUserNameUrl($url, $username);

		if ($user == NULL || ($this->userBaseLogic->findOneByUsernameUrl($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			if ($place == null) {
				throw new Nette\Application\BadRequestException;
			} else {
				$this->username = $username;
				$this->user = $user;
				$this->place = $place;
			}
		}
	}

	/**
	 * @param $username
	 * @param $url = id
	 */
	public function renderDefault($username, $url)
	{
		$this->template->place = $this->place;
		$this->template->background = $this->getBackgroundImage($this->userBaseLogic->findOneByUsernameUrl($username));
	}

	protected function createComponentProfilePlace()
	{
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profile = $this->IProfile->create($loggedUser, $this->user, TRUE);
		$profile->addComponent($this->createComponentPlaceRow($this->place, $loggedUser, $this->user), $this->place->id);

		return $profile;
	}

	protected function createComponentPlaceRow($place, $loggedUser, $profileUser)
	{
		return $this->IPlaceRow->create($place, $loggedUser, $profileUser, TRUE);
	}
}

