<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\TrackBaseLogic;
use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Profile extends Control
{

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\User */
	private $user;

    public function __construct(TrackBaseLogic $trackBaseLogic, UserBaseLogic $userBaseLogic, $username)
    {
		$this->trackBaseLogic = $trackBaseLogic;
		$this->userBaseLogic = $userBaseLogic;
		$this->user = $this->userBaseLogic->findOneByUsername($username);
    }

	public function render()
	{
		$this->template->setFile(__DIR__ . '/Profile.latte');
		$this->template->addFilter(NULL, 'App\TemplateHelpers::loader');

		$this->template->user = $this->user;
		$this->template->tracks = $this->trackBaseLogic->findLastByCount(2, $this->user->id);
		$this->template->pinnedTracks = $this->trackBaseLogic->findLasPinnedByCount(2, $this->user->id);

		$this->template->render();
	}
}