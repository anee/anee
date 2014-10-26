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

	protected function createComponentProfileContainer()
	{
		$username = $this->getUser()->getIdentity()->data['username'];
		$user = $this->userBaseLogic->findOneByUsername($username);

		$profileContainer = $this->IProfileContainer->create($username);
		foreach($user->followingUsers as $follower) {
			$profileContainer->addComponent($this->createComponentProfile($follower->username), $follower->id);
		}
		return $profileContainer;
	}
	protected function createComponentProfile($username)
	{
		return $this->IProfile->create($username);
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
