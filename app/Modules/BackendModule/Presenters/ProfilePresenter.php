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

	/** @var  \App\Modules\BackendModule\Controls\IProfileContainer @inject */
	public $IProfileContainer;

	/** @var  \App\Modules\BackendModule\Controls\IProfilePreview @inject */
	public $IProfilePreview;

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
		return $this->thumbnailsHelper->process('../app/data/users/'.$this->user->id.'/images/'.$this->user->backgroundImage, '1920x');
	}

	public function actionFollowing($username)
	{
		$user = $this->userBaseLogic->findOneByUsername($username);
		if($user == NULL || ($this->userBaseLogic->findOneByUsername($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}

	public function renderFollowing($username)
	{
		$this->template->background = $this->getBackgroundImage();
	}

	public function actionFollowers($username)
	{
		$user = $this->userBaseLogic->findOneByUsername($username);
		if($user == NULL || ($this->userBaseLogic->findOneByUsername($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}

	public function renderFollowers($username)
	{
		$this->template->background = $this->getBackgroundImage();
	}

	protected function createComponentFollowing()
	{
		$user = $this->userBaseLogic->findOneByUsername($this->username);

		$profileContainer = $this->IProfileContainer->create();
		foreach($user->following as $followingUser) {
			$profileContainer->addComponent($this->createComponentProfilePreview($user, $followingUser), $followingUser->id);
		}
		return $profileContainer;
	}

	protected function createComponentProfilePreview($profileUser, $user)
	{
		return $this->IProfilePreview->create($profileUser, $user);
	}

	protected function createComponentFollowers()
	{
		$user = $this->userBaseLogic->findOneByUsername($this->username);

		$profileContainer = $this->IProfileContainer->create();
		foreach($user->following as $followingUser) {
			$profileContainer->addComponent($this->createComponentProfilePreview($user, $followingUser), $followingUser->id);
		}
		return $profileContainer;
	}
} 