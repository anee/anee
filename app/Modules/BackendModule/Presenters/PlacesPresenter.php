<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class PlacesPresenter extends BasePresenter
{

	/** @var \App\Model\PlaceBaseLogic @inject*/
	public $placeBaseLogic;

	/** @var \App\Model\Place */
    public $place;

	public function actionDefault($username, $url)
	{
		if($this->userBaseLogic->findOneByUsername($username) == NULL || ($this->userBaseLogic->findOneByUsername($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		}
	}

	public function renderDefault($username, $url)
	{
        $this->place = $this->placeBaseLogic->findOneByNameUrlAndUserName($url, $username);

        if ($this->place == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->place = $this->place;
			$this->template->background = $this->getBackgroundImage($username);
        }
	}

	public function getBackgroundImage($username)
	{
		$user = $this->userBaseLogic->findOneByUsername($username);
		return $this->thumbnailsHelper->process('../app/data/users/'.$user->id.'/backgroundImages/'.$user->backgroundImage, '1920x');
	}
}
