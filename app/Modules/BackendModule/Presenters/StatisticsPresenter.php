<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;
use App\Model\Track;
use Nette\Utils\DateTime;

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
	 * @var \App\Model\TransportBaseLogic
	 * @inject
	 */
	public $transportBaseLogic;

	/**
	 * @var \App\Model\TrackBaseLogic
	 * @inject
	 */
	public $trackBaseLogic;

  /**
	 * @var []Place|Null
	 */
	public $places;

	/**
	* @var []Transport|Null
	*/
	public $transports;

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
	 * @var \App\Modules\BackendModule\Controls\ITrackRowFactory
	 * @inject
	 */
	public $ITrackRow;

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
		$this->transports = $this->transportBaseLogic->findAll($user->getId());

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

			$transports = $this->transports;
			foreach($transports as $transport) {
				$trackCount = 0;
				$trackAvgDistance = 0;
				$trackAvgSpeed = 0;
				$trackAvgTime = 0;

				$tracks = $this->trackBaseLogic->findAllPerYears($this->user->getId())[$this->year];
				foreach($tracks as $track) {
					if($track->transport->getName() == $transport->getName() && $track->place->getName() == $place->getName()) {
						$trackAvgDistance += $track->getDistance();
						$trackAvgSpeed += $track->getAvgSpeed();
						$trackAvgTime += $track->getTimeInSeconds();
						$trackCount += 1;
					}
				}

				if($trackCount) {
					$trackAvgDistance = round($trackAvgDistance / $trackCount, 2);
					$trackAvgSpeed = $trackAvgSpeed / $trackCount;
					$trackAvgTime = $trackAvgTime / $trackCount;

					$profile->addComponent($this->createComponentTrackRow(new Track($loggedUser, $transport, $trackAvgDistance, $trackAvgTime, $place, new DateTime(), false), $loggedUser, $this->user), $place->id . '_' . $transport->getname());
				}
			}
		}

		return $profile;
	}

	protected function createComponentTrackRow($track, $loggedUser, $profileUser)
	{
		return $this->ITrackRow->create($track, $loggedUser, $profileUser, "statistics", FALSE);
	}

	protected function createComponentPlaceRow($place, $loggedUser, $profileUser, $year)
	{
		return $this->IPlaceRow->create($place, $loggedUser, $profileUser, $year, FALSE);
	}
}
