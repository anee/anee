<?php

namespace App\Modules\BackendModule\Presenters;

use Nette\Security as NS;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	/*/** @var  \App\Modules\BackendModule\Controls\IProfileContainer @inject */
	/*public $IProfileContainer;*/

	/*/** @var  \App\Modules\BackendModule\Controls\IProfile @inject */
	/*public $IProfile;*/

	/*protected function createComponentProfileContainer()
	{
		$profileContainer = $this->IProfileContainer->create($this->getUser()->getIdentity()->data['username']);
		$profileContainer->addComponent($this->IProfile, 'a');
		return $profileContainer;
	}*/

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
