<?php

namespace App\Modules\SecurityModule\Presenters;

use App\Modules\SecurityModule\Components\TInjectSignInFormFactory;
use Nette;
use App\Model;
use Nette\Security\AuthenticationException;



class SignPresenter extends BasePresenter
{

	use TInjectSignInFormFactory;

	/**
	 * @return \App\Modules\SecurityModule\Components\SignInFormFactory
	 */
	protected function createComponentSignInFormFactory()
	{
		$form = $this->signInFormFactory->create();
		$form->onSuccess[] = $this->signInFormSucceeded;
		return $form;
	}

	public function signInFormSucceeded($form)
	{
        $values = $form->getValues();

		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}
		try {
			$this->getUser()->login($values->usernameOrEmail, $values->password);
			$this->redirect(':Backend:Homepage:default', array('username' => $this->getUser()->getIdentity()->data['username']));

		} catch (AuthenticationException $e) {
 			$form->addError($e->getMessage());
		}
	}

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->redirect(':Frontend:Homepage:default');
	}
}
