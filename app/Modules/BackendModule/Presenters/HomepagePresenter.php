<?php

namespace App\Modules\BackendModule\Presenters;

use Nette\Security as NS;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	public function renderDefault()
	{
		if($this->user->isLoggedIn()) {
			$this->template->tracks = $this->trackBaseLogic->findAllByUserId($this->getUser()->getIdentity()->data['id']);
		}
	}
}
