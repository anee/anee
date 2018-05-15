<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class StatisticsPresenter extends BasePresenter
{

	/**
	 * @var string
	 */
	public $year;

	/**
	 * @var \App\Model\PlaceBaseLogic
	 * @inject
	 */
	public $placeBaseLogic;

  /**
	 * @var []Place|Null
	 */
	public $places;

	/**
	 * @var \App\Modules\BackendModule\Controls\IProfileFactory
	 * @inject
	 */
	public $IProfile;

	/**
	 * @var \App\Modules\BackendModule\Controls\IPlaceRowFactory
	 * @inject
	 */
	public $IPlaceRow;

	/**
	 * @var \App\Modules\BackendModule\Controls\IStatisticsRowFactory
	 * @inject
	 */
	public $IStatisticsRow;

	private $username;

	private $user;

	/**
	 * @param $username
	 * @param $url = id
	 * @throws Nette\Application\BadRequestException
	 */
	public function actionDefault($username, $year)
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($username);
		$this->year = $year;
		$this->places = $this->placeBaseLogic->findAllByUserIdAndYear($user->getId(), $year);

		if ($user == NULL || ($this->userBaseLogic->findOneByUsernameUrl($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
				$this->username = $username;
				$this->user = $user;
		}
	}

	/**
	 * @param $username
	 * @param $url = id
	 */
	public function renderDefault($username, $year)
	{
		$this->template->background = $this->getBackgroundImage($this->userBaseLogic->findOneByUsernameUrl($username));
	}

	protected function createComponentProfilePlaces()
	{
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profile = $this->IProfile->create($loggedUser, $this->user, $this->year, TRUE);

		foreach($this->places as $place) {
			$profile->addComponent($this->createComponentPlaceRow($place, $loggedUser, $this->user, $this->year), $place->id);
		}

		return $profile;
	}

	protected function createComponentPlaceRow($place, $loggedUser, $profileUser, $year)
	{
		return $this->IPlaceRow->create($place, $loggedUser, $profileUser, $year, FALSE);
	}
}
