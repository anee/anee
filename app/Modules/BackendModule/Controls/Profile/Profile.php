<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\TrackBaseLogic;
use App\Model\UserBaseLogic;
use Kappa\ThumbnailsHelper\ThumbnailsHelper;
use Nette;
use Nette\Application\UI\Control;
use Nette\Utils\Image;


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
	private $user;

	private $wwwDir;

    public function __construct(ThumbnailsHelper $thumbnailsHelper, TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, $wwwDir, $username)
    {
		$this->wwwDir = $wwwDir;
		$this->thumbnailsHelper = $thumbnailsHelper;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->user = $this->userBaseLogic->findOneByUsername($username);
    }

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');
		$this->template->addFilter('thumb', array($this->thumbnailsHelper, 'process'));

		$this->template->user = $this->user;
		$this->template->background = $this->getBackgroundImage();
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

	public function getBackgroundImage()
	{
		return $this->thumbnailsHelper->process('../app/data/users/'.$this->user->id.'/backgroundImages/'.$this->user->backgroundImage, '1920x');
	}
}