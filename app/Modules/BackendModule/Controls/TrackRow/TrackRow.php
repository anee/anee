<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\TrackBaseLogic;
use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;
use App\Model\Track;
use App\Model\User;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TrackRow extends Control
{

	/** @var \App\Model\UserBaseLogic */
	public $userBaseLogic;

	/** @var \App\Model\TrackBaseLogic */
	public $trackBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	/** @var \App\Model\User */
	private $profileUser;

	/** @var \App\Model\Track */
	private $track;

	/** @var bool which say if is home page or profile page */
	private $byName;

	/** @var bool which say if is detail of concrete track or not */
	private $detail;

    public function __construct(TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, Track $track, User $loggedUser, User $profileUser, $byName = NULL, $detail = NULL)
    {
		$this->track = $track;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
		$this->profileUser = $profileUser;
		$this->byName = $byName;
		$this->detail = $detail;
    }

	public function render($file)
	{
		$this->template->setFile($file);

		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->track = $this->track;
		$this->template->byName = $this->byName;
		$this->template->detail = $this->detail;

		$this->template->render();
	}

	public function handlePin($id)
	{
		$track = $this->trackBaseLogic->findOneById($id);
		$track->pinned = TRUE;
		$this->trackBaseLogic->save($track);
		$this->redirect('this');
	}

	public function handleUnpin($id)
	{
		$track = $this->trackBaseLogic->findOneById($id);
		$track->pinned = FALSE;
		$this->trackBaseLogic->save($track);
		$this->redirect('this');
	}

	public function handleRemove($id)
	{
		$this->trackBaseLogic->remove($id);
		$this->redirect('this');
	}
}