<?php


namespace App\Modules\BackendModule\Presenters;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class ProfilePresenter extends BasePresenter
{


	/**
	 * @var  \App\Modules\BackendModule\Controls\IProfileFactory
	 * @inject
	 */
	public $IProfile;

	/**
	 * Profile username
	 */
	private $username;

	/**
	 * @var \App\Model\User
	 */
	private $user;

	/**
	 * @var \App\Model\TrackBaseLogic
	 * @inject
	 */
	public $trackBaseLogic;

	/**
	 * @var \App\Model\PlaceBaseLogic
	 * @inject
	 */
	public $placeBaseLogic;

	/**
	 * @var \App\Model\PhotoBaseLogic
	 * @inject
	 */
	public $photoBaseLogic;

	/**
	 * @var  \App\Modules\BackendModule\Controls\IProfileContainerFactory
	 * @inject
	 */
	public $IProfileContainer;

	/**
	 * @var  \App\Modules\BackendModule\Controls\IProfilePreviewFactory
	 * @inject
	 */
	public $IProfilePreview;

	/**
	 * @var  \App\Modules\BackendModule\Controls\ITrackRowFactory
	 * @inject
	 */
	public $ITrackRow;

	/**
	 * @var \App\Modules\BackendModule\Controls\IPlaceRowFactory
	 * @inject
	 */
	public $IPlaceRow;

	/**
	 * @var \App\Modules\BackendModule\Controls\IPhotoRowFactory
	 * @inject
	 */
	public $IPhotoRow;

	protected function createComponentProfile()
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($this->username);
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profile = $this->IProfile->create($loggedUser, $user);
		$tracks = $this->trackBaseLogic->findAll($user->id);
		foreach ($tracks as $track) {
			if ($track->pinned == NULL) {
				$profile->addComponent($this->createComponentTrackRow($track, $loggedUser, $user), 'NO' . $track->id);
			} elseif ($track->pinned == TRUE) {
				$profile->addComponent($this->createComponentTrackRow($track, $loggedUser, $user), 'YES' . $track->id);
			}
		}
		return $profile;
	}

	protected function createComponentTrackRow($track, $loggedUser, $profileUser)
	{
		return $this->ITrackRow->create($track, $loggedUser, $profileUser);
	}

	protected function createComponentPhotoRow($photo, $loggedUser, $profileUser)
	{
		return $this->IPhotoRow->create($photo, $loggedUser, $profileUser);
	}

	protected function createComponentPlaceRow($place, $loggedUser, $profileUser)
	{
		return $this->IPlaceRow->create($place, $loggedUser, $profileUser);
	}

	public function actionDefault($username)
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($username);

		if ($user == NULL || ($this->userBaseLogic->findOneByUsernameUrl($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}

	public function renderDefault($username)
	{
		$this->template->background = $this->getBackgroundImage($this->user);
	}

	public function actionFollowing($username)
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($username);

		if ($user == NULL || ($this->userBaseLogic->findOneByUsernameUrl($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}

	public function renderFollowing($username)
	{
		$this->template->background = $this->getBackgroundImage($this->user);
	}

	public function actionFollowers($username)
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($username);
		if ($user == NULL || ($this->userBaseLogic->findOneByUsernameUrl($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}

	public function renderFollowers($username)
	{
		$this->template->background = $this->getBackgroundImage($this->user);
	}

	protected function createComponentFollowing()
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($this->username);

		$profileContainer = $this->IProfileContainer->create();
		foreach ($user->following as $followingUser) {
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
		$user = $this->userBaseLogic->findOneByUsernameUrl($this->username);

		$profileContainer = $this->IProfileContainer->create();
		foreach ($user->followers as $followerUser) {
			$profileContainer->addComponent($this->createComponentProfilePreview($user, $followerUser), $followerUser->id);
		}
		return $profileContainer;
	}

	public function actionTracks($username)
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($username);

		if ($user == NULL || ($this->userBaseLogic->findOneByUsernameUrl($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}

	public function renderTracks($username)
	{
		$this->template->background = $this->getBackgroundImage($this->user);
	}

	protected function createComponentProfileTracks()
	{
		$profileUser = $this->userBaseLogic->findOneByUsernameUrl($this->username);
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profile = $this->IProfile->create($loggedUser, $this->user);
		$tracks = $this->trackBaseLogic->findAll($profileUser->id);
		foreach ($tracks as $track) {
			$profile->addComponent($this->createComponentTrackRow($track, $loggedUser, $this->user), $track->id);
		}
		return $profile;
	}

	public function renderPlaces($username)
	{
		$this->template->background = $this->getBackgroundImage($this->user);
	}

	protected function createComponentProfilePlaces()
	{
		$profileUser = $this->userBaseLogic->findOneByUsernameUrl($this->username);
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profile = $this->IProfile->create($loggedUser, $this->user);
		$places = $this->placeBaseLogic->findAll($profileUser->id);
		foreach ($places as $place) {
			$profile->addComponent($this->createComponentPlaceRow($place, $loggedUser, $this->user), $place->id);
		}
		return $profile;
	}

	public function actionPlaces($username)
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($username);

		if ($user == NULL || ($this->userBaseLogic->findOneByUsernameUrl($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}

	public function renderPhotos($username)
	{
		$this->template->background = $this->getBackgroundImage($this->user);
	}

	protected function createComponentProfilePhotos()
	{
		$profileUser = $this->userBaseLogic->findOneByUsernameUrl($this->username);
		$loggedUser = $this->userBaseLogic->findOneById($this->getUser()->getId());

		$profile = $this->IProfile->create($loggedUser, $this->user);
		$photos = $this->photoBaseLogic->findAll($profileUser->id);
		foreach ($photos as $photo) {
			$profile->addComponent($this->createComponentPhotoRow($photo, $loggedUser, $this->user), $photo->id);
		}
		return $profile;
	}

	public function actionPhotos($username)
	{
		$user = $this->userBaseLogic->findOneByUsernameUrl($username);

		if ($user == NULL || ($this->userBaseLogic->findOneByUsernameUrl($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
			$this->user = $user;
		}
	}
} 