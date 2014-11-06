<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\TrackBaseLogic;
use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;
use App\Model\Photo;
use App\Model\User;
use Kappa\ThumbnailsHelper\ThumbnailsHelper;
use Nette\Utils\Image;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PhotoRow extends Control
{

	/** @var \App\Model\UserBaseLogic */
	public $userBaseLogic;

	/** @var \App\Model\TrackBaseLogic */
	public $trackBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	/** @var \App\Model\User */
	private $profileUser;

	/** @var \App\Model\Photo */
	private $photo;

	/** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper */
	public $thumbnailsHelper;

	private $wwwDir;

    public function __construct(ThumbnailsHelper $thumbnailsHelper, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, $wwwDir, Photo $photo, User $loggedUser, User $profileUser)
    {
		$this->wwwDir = $wwwDir;
		$this->thumbnailsHelper = $thumbnailsHelper;
		$this->photo = $photo;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
    }

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->photo = $this->photo;

		$this->template->render();
	}

	public function handleRemove($id)
	{
		$this->trackBaseLogic->remove($id);
		$this->redirect('this');
	}

	public function handleGetImage()
	{
		$image = $this->thumbnailsHelper->process('../app/data/users/' . $this->profileUser->id . '/photos/' . $this->photo->fileName, '677x');
		$image = Image::fromFile($this->wwwDir . '/' . $image);
		$image->send();
	}
}