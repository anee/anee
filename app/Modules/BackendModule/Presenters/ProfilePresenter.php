<?php


namespace App\Modules\BackendModule\Presenters;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class ProfilePresenter extends BasePresenter {


	/** @var  \App\Modules\BackendModule\Controls\IProfile @inject */
	public $IProfile;

	/** Profile username */
	private $username;

	/** @var \App\Model\User */
	private $user;

	protected function createComponentProfile()
	{
		return $this->IProfile->create($this->userBaseLogic->findOneById($this->getUser()->getId()), $this->user);
	}

	public function actionDefault($username)
	{
		$user = $this->userBaseLogic->findOneByUsername($username);
		if($user == NULL || ($this->userBaseLogic->findOneByUsername($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}

	public function renderDefault($username)
	{
		$this->template->background = $this->getBackgroundImage();
	}

	public function getBackgroundImage()
	{
		return $this->thumbnailsHelper->process('../app/data/users/'.$this->user->id.'/backgroundImages/'.$this->user->backgroundImage, '1920x');
	}
} 