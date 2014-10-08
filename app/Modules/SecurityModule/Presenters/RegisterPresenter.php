<?php

namespace App\Modules\SecurityModule\Presenters;

use App\Modules\SecurityModule\Components\TInjectRegisterInFormFactory;
use Nette;
use App\Model;


class RegisterPresenter extends BasePresenter
{

	use TInjectRegisterInFormFactory;

	/**
	 * @return \App\Modules\SecurityModule\Components\RegisterInFormFactory
	 */
	protected function createComponentRegisterInFormFactory()
	{
		return $this->registerInFormFactory->create();
	}
}
