<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\Track;
use App\Model\UserBaseLogic;
use Kdyby\Doctrine\DuplicateEntryException;
use Nette;
use Nette\Application\UI\Control;
use App\Model\User;
use Nette\Application\UI\Form;
use ViewKeeper\ViewKeeper;
use Nette\Utils\DateTime;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IStatisticsRowFactory
{

	/**
	 * @param $years
	 * @param array $tracks
	 * @param User $loggedUser
	 * @param User $profileUser
	 *
	 * @return StatisticsRow
	 */
	function create($year, $tracks, User $loggedUser, User $profileUser);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class StatisticsRow extends Control
{

  /**
	 * @var User
	 */
	private $loggedUser;

	/**
	 * @var User
	 */
	private $profileUser;

	/**
	 * @var Track[]
	 */
	private $tracks;

	/**
	 * @var
	 */
	private $year;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

  public function __construct($year, $tracks, User $loggedUser = NULL, User $profileUser, ViewKeeper $keeper)
  {
		$this->keeper = $keeper;
		$this->tracks = $tracks;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
		$this->year = $year;
  }

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'StatisticsRow', 'controls'));

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$yearDistance = 0;
		$yearTimeInSeconds = 0;
		foreach ($this->tracks as $track) {
		    /** @var Track $track */
        $yearDistance += $track->getDistance();
        $yearTimeInSeconds += $track->getTimeInSeconds();
    }
    $this->template->yearTimeInSeconds = $yearTimeInSeconds;
		$this->template->yearDistance = $yearDistance;
    $this->template->yearTracks = $this->tracks;
		$this->template->lastUpdate = $this->getLastUpdate();

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->year = $this->year;

		$this->template->render();
	}

	private function getLastUpdate() {
		$dateTime = new DateTime();
		$count = 0;
		if(count($this->tracks) > 0) {
		foreach($this->tracks as $track) {
			if($count == 0 || $track->getDate() > $dateTime) {
						$dateTime = $track->getDate();
						$count++;
				}
			}
		} else {
			return NULL;
		}
		return $dateTime;
	}
}
