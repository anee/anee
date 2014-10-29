<?php

namespace App\Modules\BackendModule\Presenters;

use Nette\Security as NS;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	/** @var  \App\Modules\BackendModule\Controls\IProfileContainer @inject */
	public $IProfileContainer;

	/** @var  \App\Modules\BackendModule\Controls\IProfile @inject */
	public $IProfile;

	protected function createComponentFollowing()
	{
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profileContainer = $this->IProfileContainer->create();
		foreach($loggedUser->following as $followingUser) {
			$profileContainer->addComponent($this->createComponentProfile($loggedUser, $followingUser), $followingUser->id);
		}
		return $profileContainer;
	}

	protected function createComponentProfile($loggedUser, $user)
	{
		return $this->IProfile->create($loggedUser, $user);
	}

	public function renderDefault()
	{
		$this->template->background = $this->getBackgroundImage();
	}

	public function getBackgroundImage()
	{
		$user = $this->userBaseLogic->findOneById($this->getUser()->getId());
		return $this->thumbnailsHelper->process('../app/data/users/'.$this->user->id.'/backgroundImages/'.$user->backgroundImage, '1920x');
	}
}
