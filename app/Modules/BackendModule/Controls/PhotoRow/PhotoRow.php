<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\PhotoBaseLogic;
use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;
use App\Model\Photo;
use App\Model\User;
use Kappa\ThumbnailsHelper\ThumbnailsHelper;
use Nette\Utils\Image;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IPhotoRowFactory
{

	/**
	 * @param Photo $photo
	 * @param User $loggedUser
	 * @param User $profileUser
	 * @return PhotoRow
	 */
	function create(Photo $photo, User $loggedUser, User $profileUser);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoRow extends Control
{

	/**
	 * @var \App\Model\UserBaseLogic
	 */
	public $userBaseLogic;

	/**
	 * @var \App\Model\PhotoBaseLogic
	 */
	public $photoBaseLogic;

	/**
	 * @var \App\Model\User
	 */
	private $loggedUser;

	/**
	 * @var \App\Model\User
	 */
	private $profileUser;

	/**
	 * @var \App\Model\Photo
	 */
	private $photo;

	/**
	 * @var \Kappa\ThumbnailsHelper\ThumbnailsHelper
	 */
	public $thumbnailsHelper;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

	private $wwwDir;

    public function __construct(ViewKeeper $keeper, ThumbnailsHelper $thumbnailsHelper, PhotoBaseLogic $photoBaseLogic, UserBaseLogic $userBaseLogic, $wwwDir, Photo $photo, User $loggedUser, User $profileUser)
    {
		$this->keeper = $keeper;
		$this->wwwDir = $wwwDir;
		$this->thumbnailsHelper = $thumbnailsHelper;
		$this->photo = $photo;
		$this->photoBaseLogic = $photoBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
    }

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'PhotoSRow', 'controls'));

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->photo = $this->photo;

		$this->template->render();
	}

	public function handleRemove($id)
	{
		if ($this->getPresenter()->isAjax()) {
			$this->photoBaseLogic->remove($id);

			$this->redirect('this');
		}
	}

	public function handleGetImage()
	{
		$image = $this->thumbnailsHelper->process('../app/data/users/' . $this->profileUser->id . '/photos/' . $this->photo->fileName, '677x');
		$image = Image::fromFile($this->wwwDir . '/' . $image);
		$image->send();
	}
}