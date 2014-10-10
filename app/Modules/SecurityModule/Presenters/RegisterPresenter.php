<?php

namespace App\Modules\SecurityModule\Presenters;

use Nette;


class RegisterPresenter extends BasePresenter
{

	/** @var \App\Modules\SecurityModule\Controls\IRegisterIn @inject */
	public $IRegisterIn;

	public function createComponentRegisterIn()
	{
		return $this->IRegisterIn->create();
	}
}
