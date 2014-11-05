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


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Profile extends Control
{

	/** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
	public $thumbnailsHelper;

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

	/** @var \App\Model\PlaceBaseLogic @inject*/
	public $placeBaseLogic;

	/** @var \App\Model\PhotoBaseLogic @inject*/
	public $photoBaseLogic;

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	/** @var \App\Model\User */
	private $profileUser;

	private $wwwDir;

	/** @var \App\Modules\BackendModule\Controls\ITransportsModal @inject */
	public $ITransportsModal;

	/** @var \App\Modules\BackendModule\Controls\IAddTrackModal @inject */
	public $IAddTrackModal;

	/** @var \App\Modules\BackendModule\Controls\IAddPhotoModal @inject */
	public $IAddPhotoModal;

    public function __construct(IAddPhotoModal $IAddPhotoModal, IAddTrackModal $IAddTrackModal, ITransportsModal $ITransportsModal, ThumbnailsHelper $thumbnailsHelper, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, PlaceBaseLogic $placeBaseLogic, PhotoBaseLogic $photoBaseLogic, $wwwDir, User $loggedUser, User $profileUser)
    {
		$this->wwwDir = $wwwDir;
		$this->thumbnailsHelper = $thumbnailsHelper;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
		$this->ITransportsModal = $ITransportsModal;
		$this->IAddTrackModal = $IAddTrackModal;
		$this->IAddPhotoModal = $IAddPhotoModal;
		$this->placeBaseLogic = $placeBaseLogic;
		$this->photoBaseLogic = $photoBaseLogic;
    }

	protected function createComponentTransportsModal()
	{
		return $this->ITransportsModal->create($this->profileUser, $this->loggedUser);
	}

	protected function createComponentAddTrackModal()
	{
		return $this->IAddTrackModal->create($this->profileUser, $this->loggedUser);
	}

	protected function createComponentAddPhotoModal()
	{
		return $this->IAddPhotoModal->create($this->profileUser, $this->loggedUser);
	}

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');
		$this->template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;

		$unpinnedTracks = Array();
		$pinnedTracks = Array();
		$tracks = FALSE;
		$places = FALSE;
		if($this->getPresenter()->getAction() == 'default') {
			$unpinnedTracks = $this->trackBaseLogic->findAllUnpinnedByUserId($this->profileUser->id);
			$pinnedTracks = $this->trackBaseLogic->findAllPinnedByUserId($this->profileUser->id);
		} elseif($this->getPresenter()->getAction() == 'tracks') {
			$tracks = TRUE;
		} elseif ($this->getPresenter()->getAction() == 'places') {
			$places = TRUE;
		}
		$this->template->unpinnedTracks = $unpinnedTracks;
		$this->template->pinnedTracks = $pinnedTracks;
		$this->template->tracks = $tracks;
		$this->template->places = $places;

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