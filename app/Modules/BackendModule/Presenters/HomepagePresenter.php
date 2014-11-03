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

	/** @var  \App\Modules\BackendModule\Controls\IProfilePreview @inject */
	public $IProfilePreview;

	protected function createComponentFollowing()
	{
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profileContainer = $this->IProfileContainer->create();
		foreach($loggedUser->following as $followingUser) {
			$profileContainer->addComponent($this->createComponentProfilePreview($loggedUser, $followingUser), $followingUser->id);
		}
		return $profileContainer;
	}

	protected function createComponentProfilePreview($loggedUser, $user)
	{
		return $this->IProfilePreview->create($loggedUser, $user);
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
}
