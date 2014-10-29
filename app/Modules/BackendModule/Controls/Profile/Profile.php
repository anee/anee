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


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Profile extends Control
{

	/** @var \Kappa\ThumbnailsHelper\ThumbnailsHelper @inject*/
	public $thumbnailsHelper;

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	/** @var \App\Model\User */
	private $user;

	private $wwwDir;

    public function __construct(ThumbnailsHelper $thumbnailsHelper, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, $wwwDir, User $loggedUser, User $user)
    {
		$this->wwwDir = $wwwDir;
		$this->thumbnailsHelper = $thumbnailsHelper;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->user = $user;
    }

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');
		$this->template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

		$this->template->user = $this->user;
		$this->template->userLogged = $this->loggedUser;
		$this->template->tracks = $this->trackBaseLogic->findLastByCount(2, $this->user->id);
		$this->template->pinnedTracks = $this->trackBaseLogic->findLasPinnedByCount(2, $this->user->id);

		$this->template->render();
	}

	public function handleGetProfileImage()
	{
		$image = $this->thumbnailsHelper->process('../app/data/users/'.$this->user->id.'/profileImages/'.$this->user->profileImage, '500x');
		$image = Image::fromFile($this->wwwDir.'/'.$image);
		$image->send();
	}

	public function handleFollow()
	{
		try {
			$this->loggedUser->following->add($this->user);
			$this->userBaseLogic->save($this->loggedUser);
		} catch(DuplicateEntryException $e) {

		}
		$this->getPresenter()->redirect(':Backend:Profile:Default', array ('username' => $this->user->username));
	}

	public function handleUnfollow()
	{
		$this->user->removeFollower($this->loggedUser);
		$this->userBaseLogic->save($this->loggedUser, $this->user);
		$this->getPresenter()->redirect(':Backend:Profile:Default', array ('username' => $this->user->username));
	}
}