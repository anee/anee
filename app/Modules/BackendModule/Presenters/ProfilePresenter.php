<?php


namespace App\Modules\BackendModule\Presenters;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class ProfilePresenter extends BasePresenter {


	/** @var  \App\Modules\BackendModule\Controls\IProfile @inject */
	public $IProfile;

	/** Profile username */
	private $username;

	protected function createComponentProfile()
	{
		return $this->IProfile->create($this->username);
	}

	public function actionDefault($username)
	{
		if($this->userBaseLogic->findOneByUsername($username) == NULL || ($this->userBaseLogic->findOneByUsername($username)->public == FALSE && !$this->getUser()->isLoggedIn())) {
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$this->username = $username;
		}
	}
} 