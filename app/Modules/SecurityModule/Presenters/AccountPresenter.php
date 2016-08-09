<?php

namespace App\Modules\SecurityModule\Presenters;

use App\Model\UserBaseLogic;



class AccountPresenter extends \App\Modules\BaseModule\Presenters\BasePresenter
{

	/**
	 * @var UserBaseLogic
	 * @inject
	 */
	public $userBaseLogic;

	public function actionRemove()
	{
		$this->userBaseLogic->remove($this->getUser()->getId());
		$this->redirect(':Security:Sign:out');
	}

}
