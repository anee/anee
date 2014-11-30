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

			/** Added all tracks from following users BUT ignore tracks from myself */
			foreach ($loggedUser->following as $followingUser) {
				foreach ($followingUser->tracks as $track) {
					if ($loggedUser->id != $followingUser->id) {
						$this->addComponent($this->createComponentTrackRow($track, $loggedUser, $followingUser, TRUE), 'Track' . $track->id);
					}
				}
			}

			/** Updated LastVisitedHome after displaying all tracks */
			$loggedUser->setLastVisitedHome(new DateTime());
			$this->userBaseLogic->save($loggedUser);
		}
	}

	public function renderDefault()
	{
		$this->template->background = $this->getBackgroundImage($this->userBaseLogic->findOneById($this->getUser()->getId()));
	}

	protected function createComponentTrackRow($track, $loggedUser, $profileUser, $byName)
	{
		return $this->ITrackRow->create($track, $loggedUser, $profileUser, $byName);
	}
}
