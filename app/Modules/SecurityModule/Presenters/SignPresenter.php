<?php

namespace App\Modules\SecurityModule\Presenters;

use Nette;


class SignPresenter extends BasePresenter
{

	/** @var \App\Modules\SecurityModule\Controls\ISignIn @inject */
	public $ISignIn;

	public function createComponentSignIn()
	{
		return $this->ISignIn->create();
	}

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->redirect(':Backend:Homepage:default');
	}
}
