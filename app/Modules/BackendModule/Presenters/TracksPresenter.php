<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TracksPresenter extends BasePresenter
{

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\Track */
    public $track;

	/** @var \App\Modules\BackendModule\Controls\IProfile @inject */
	public $IProfile;

	/** @var \App\Modules\BackendModule\Controls\ITrackRow @inject */
	public $ITrackRow;

	private $username;

	private $user;

	/**
	 * @param $username
	 * @param $url = id
	 * @throws Nette\Application\BadRequestException
	 */
	public function actionDefault($username, $url)
	{
		$user = $this->userBaseLogic->findOneByUsername($username);
		$track = $this->trackBaseLogic->findOneByIdAndUserName($url, $username);

		if($user == NULL || ($this->userBaseLogic->findOneByUsername($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			if ($track == null) {
				throw new Nette\Application\BadRequestException;
			} else {
				$this->username = $username;
				$this->user = $user;
				$this->track = $track;;
			}
		}
	}

	/**
	 * @param $username
	 * @param $url = id
	 */
	public function renderDefault($username, $url)
	{
		$this->template->track = $this->track;
		$this->template->background = $this->getBackgroundImage($this->userBaseLogic->findOneByUsername($username));
	}

	protected function createComponentProfileTrack()
	{
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profile = $this->IProfile->create($loggedUser, $this->user, TRUE);
		$profile->addComponent($this->createComponentTrackRow($this->track, $loggedUser, $this->user), $this->track->id);

		return $profile;
	}

	protected function createComponentTrackRow($track, $loggedUser, $profileUser)
	{
		return $this->ITrackRow->create($track, $loggedUser, $profileUser, NULL, TRUE);
	}
}
