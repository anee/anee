<?php

namespace App\Modules\SecurityModule\Presenters;



class RegisterPresenter extends BasePresenter
{

	/**
	 * @var \App\Modules\SecurityModule\Controls\IRegisterInFactory
	 * @inject
	 */
	public $IRegisterIn;

	public function createComponentRegisterIn()
	{
		return $this->IRegisterIn->create();
	}
}
