<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\TrackBaseLogic;
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
interface IProfilePreviewFactory
{

	/**
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @return ProfilePreview
	 */
	function create(User $loggedUser, User $profileUser);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class ProfilePreview extends Control
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
	 * @var \App\Modules\BackendModule\Controls\IProfileModalFactory
	 */
	public $IProfileModal;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

    public function __construct($wwwDir, User $loggedUser, User $profileUser, ViewKeeper $keeper, IProfileModalFactory $IProfileModal, ITransportsModalFactory $ITransportsModal, ThumbnailsHelper $thumbnailsHelper, UserBaseLogic $userBaseLogic)
    {
		$this->keeper = $keeper;
		$this->IProfileModal = $IProfileModal;
		$this->ITransportsModal = $ITransportsModal;
		$this->wwwDir = $wwwDir;
		$this->thumbnailsHelper = $thumbnailsHelper;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
    }

	protected function createComponentProfileModal()
	{
		return $this->IProfileModal->create($this->loggedUser, $this->profileUser);
	}

	protected function createComponentTransportsModal()
	{
		return $this->ITransportsModal->create($this->profileUser, $this->loggedUser);
	}

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'ProfilePreview', 'controls'));

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');
		$this->template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;

		$this->template->render();
	}

	public function handleGetProfileImage()
	{
		if ($this->profileUser->profileImage != NULL) {
			$image = $this->thumbnailsHelper->process('../app/data/users/' . $this->profileUser->id . '/images/' . $this->profileUser->profileImage, '500x');
			$image = Image::fromFile($this->wwwDir . '/' . $image);
			$image->send();
		} else {
			$image = Image::fromBlank(500, 300, Image::rgb(153,153,153));
			$image->send();
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