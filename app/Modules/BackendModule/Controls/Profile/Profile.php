<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\TrackBaseLogic;
use App\Model\PhotoBaseLogic;
use App\Model\PlaceBaseLogic;
use App\Model\UserBaseLogic;
use Kappa\ThumbnailsHelper\ThumbnailsHelper;
use Kdyby\Doctrine\DuplicateEntryException;
use Nette;
use Nette\Application\UI\Control;
use Nette\Utils\Image;
use App\Model\User;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IProfileFactory
{

	/**
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @param bool $detail
	 * @return Profile
	 */
	function create(User $loggedUser, User $profileUser, $detail = NULL);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Profile extends Control
{

	/**
	 * @var \Kappa\ThumbnailsHelper\ThumbnailsHelper
	 */
	public $thumbnailsHelper;

	/**
	 * @var \App\Model\UserBaseLogic
	 */
	public $userBaseLogic;

	/**
	 * @var \App\Model\PlaceBaseLogic
	 */
	public $placeBaseLogic;

	/**
	 * @var \App\Model\PhotoBaseLogic
	 */
	public $photoBaseLogic;

	/**
	 * @var \App\Model\TrackBaseLogic
	 */
	public $trackBaseLogic;

	/**
	 * @var \App\Model\User
	 */
	private $loggedUser;

	/**
	 * @var \App\Model\User
	 */
	private $profileUser;

	private $wwwDir;

	/**
	 * @var \App\Modules\BackendModule\Controls\ITransportsModalFactory
	 */
	public $ITransportsModal;

	/**
	 * @var \App\Modules\BackendModule\Controls\IAddTrackModalFactory
	 */
	public $IAddTrackModal;

	/**
	 * @var \App\Modules\BackendModule\Controls\IAddPhotoModalFactory
	 */
	public $IAddPhotoModal;

	/**
	 * @var \App\Modules\BackendModule\Controls\IAddPlaceModalFactory
	 */
	public $IAddPlaceModal;

	/** bool which say if we will display detail of one track or summary*/
	private $detail;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

    public function __construct(ViewKeeper $keeper, IAddPlaceModalFactory $IAddPlaceModal, IAddPhotoModalFactory $IAddPhotoModal, IAddTrackModalFactory $IAddTrackModal, ITransportsModalFactory $ITransportsModal, ThumbnailsHelper $thumbnailsHelper, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, PlaceBaseLogic $placeBaseLogic, PhotoBaseLogic $photoBaseLogic, $wwwDir, User $loggedUser, User $profileUser, $detail = NULL)
    {
		$this->keeper = $keeper;
		$this->wwwDir = $wwwDir;
		$this->thumbnailsHelper = $thumbnailsHelper;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
		$this->ITransportsModal = $ITransportsModal;
		$this->IAddTrackModal = $IAddTrackModal;
		$this->IAddPhotoModal = $IAddPhotoModal;
		$this->IAddPlaceModal = $IAddPlaceModal;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->photoBaseLogic = $photoBaseLogic;
		$this->detail = $detail;
    }

	protected function createComponentTransportsModal()
	{
		return $this->ITransportsModal->create($this->profileUser, $this->loggedUser);
	}

	protected function createComponentAddTrackModal()
	{
		return $this->IAddTrackModal->create($this->loggedUser);
	}

	protected function createComponentAddPhotoModal()
	{
		return $this->IAddPhotoModal->create($this->loggedUser);
	}

	protected function createComponentAddPlaceModal()
	{
		return $this->IAddPlaceModal->create($this->loggedUser);
	}

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . $this->name, 'controls'));

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');
		$this->template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;

		$unpinnedTracks = Array();
		$pinnedTracks = Array();
		$tracks = FALSE;
		$places = FALSE;
		$photos = FALSE;
		if($this->getPresenter()->getAction() == 'tracks' || ($this->getPresenter()->getName() == 'Backend:Tracks' && $this->getPresenter()->getAction() == 'default')) {
			$tracks = TRUE;
		} elseif ($this->getPresenter()->getAction() == 'places' || ($this->getPresenter()->getName() == 'Backend:Places' && $this->getPresenter()->getAction() == 'default')) {
			$places = TRUE;
		} elseif ($this->getPresenter()->getAction() == 'photos' || ($this->getPresenter()->getName() == 'Backend:Photos' && $this->getPresenter()->getAction() == 'default')) {
			$photos = TRUE;
		} elseif($this->getPresenter()->getAction() == 'default') {
			$unpinnedTracks = $this->trackBaseLogic->findAllUnpinnedByUserId($this->profileUser->id);
			$pinnedTracks = $this->trackBaseLogic->findAllPinnedByUserId($this->profileUser->id);
		}
		$this->template->unpinnedTracks = $unpinnedTracks;
		$this->template->pinnedTracks = $pinnedTracks;
		$this->template->tracks = $tracks;
		$this->template->places = $places;
		$this->template->photos = $photos;
		$this->template->detail = $this->detail;

		$this->template->render();
	}

	public function handleGetProfileImage()
	{
		if($this->profileUser->profileImage != NULL) {
			$image = $this->thumbnailsHelper->process('../app/data/users/' . $this->profileUser->id . '/images/' . $this->profileUser->profileImage, '500x');
			$image = Image::fromFile($this->wwwDir . '/' . $image);
			$image->send();
		} else {
			return NULL;
		}
	}

	public function handleFollow()
	{
		try {
			$this->loggedUser->following->add($this->profileUser);
			$this->userBaseLogic->save($this->loggedUser);
		} catch(DuplicateEntryException $e) {

		}
		$this->getPresenter()->redirect('this');
	}

	public function handleUnfollow()
	{
		$this->profileUser->removeFollower($this->loggedUser);
		$this->userBaseLogic->save($this->loggedUser, $this->profileUser);
		$this->getPresenter()->redirect('this');
	}
}