<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TracksPresenter extends BasePresenter
{

	/** @var \App\Model\UserBaseLogic @inject */
	public $userBaseLogic;

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\Track */
    public $track;

	public function actionDefault($username, $id)
	{
		if($this->userBaseLogic->findOneByUsername($username) == NULL || ($this->userBaseLogic->findOneByUsername($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		}
	}

	public function renderDefault($username, $id)
	{
        $this->track = $this->trackBaseLogic->findOneByIdAndUserName($id, $username);

        if ($this->track == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->track = $this->track;
        }
	}
}
