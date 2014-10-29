<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TracksPresenter extends BasePresenter
{

	/** @var \App\Model\TrackBaseLogic @inject*/
	public $trackBaseLogic;

	/** @var \App\Model\Track */
    public $track;

	/**
	 * @param $username
	 * @param $url = id
	 */
	public function actionDefault($username, $url)
	{
		if($this->userBaseLogic->findOneByUsername($username) == NULL || ($this->userBaseLogic->findOneByUsername($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		}
	}

	/**
	 * @param $username
	 * @param $url = id
	 * @throws Nette\Application\BadRequestException
	 */
	public function renderDefault($username, $url)
	{
        $this->track = $this->trackBaseLogic->findOneByIdAndUserName($url, $username);

        if ($this->track == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->track = $this->track;
			$this->template->background = $this->getBackgroundImage($username);
        }
	}

	public function getBackgroundImage($username)
	{
		$user = $this->userBaseLogic->findOneByUsername($username);
		return $this->thumbnailsHelper->process('../app/data/users/'.$user->id.'/backgroundImages/'.$user->backgroundImage, '1920x');
	}
}
