<?php

namespace App\Modules\SecurityModule\Controls;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SignIn extends Nette\Application\UI\Control
{

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->render();
	}

    protected function createComponentSignInForm()
    {
		$form = new Form;
		$form->addText('usernameOrEmail')->setRequired('Please enter your username or email.')
			->setAttribute('placeholder', 'E-mail or username');
		$form->addPassword('password')
			->setRequired('Please enter your password.')
			->setAttribute('placeholder', 'Password');
		$form->addCheckbox('remember', 'Remember me');
		$form->addSubmit('send', 'sign');
		$form->onSuccess[] = $this->success;
		return $form;
    }

	public function success($form)
	{
		$values = $form->getValues();

		if ($values->remember) {
			$this->getPresenter()->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getPresenter()->getUser()->setExpiration('20 minutes', TRUE);
		}
		try {
			$this->getPresenter()->getUser()->login($values->usernameOrEmail, $values->password);
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} catch (AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}
}