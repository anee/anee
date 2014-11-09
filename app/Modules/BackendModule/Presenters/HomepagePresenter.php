<?php

namespace App\Modules\BackendModule\Presenters;

use Nette\Security as NS;
use Nette\Utils\DateTime;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	/** @var \App\Modules\BackendModule\Controls\ITrackRow @inject */
	public $ITrackRow;

	public function actionDefault()
	{
		if ($this->user->isLoggedIn()) {
			$loggedUser = $this->userBaseLogic->findOneById($this->user->id);

			/** Added all tracks from following users */
			foreach ($loggedUser->following as $followingUser) {
				foreach($followingUser->tracks as $track) {
					$this->addComponent($this->createComponentTrackRow($track, $loggedUser, $followingUser), 'Track'.$track->id);
				}
			}

			/** Updated LastVisitedHome after displaying all tracks */
			$loggedUser->setLastVisitedHome(new DateTime());
			$this->userBaseLogic->save($loggedUser);
		}
	}

	public function renderDefault()
	{
		$this->template->background = $this->getBackgroundImage();
	}

	public function getBackgroundImage()
	{
		$user = $this->userBaseLogic->findOneById($this->getUser()->getId());
		return $this->thumbnailsHelper->process('../app/data/users/'.$this->user->id.'/images/'.$user->backgroundImage, '1920x');
	}

	protected function createComponentTrackRow($track, $loggedUser, $profileUser)
	{
		return $this->ITrackRow->create($track, $loggedUser, $profileUser);
	}
}
