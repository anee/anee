<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 9.7.14
 * Time: 19:31
 * To change this template use File | Settings | File Templates.
 */

namespace App\Modules\SecurityModule\Controls;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SignIn extends Nette\Application\UI\Control
{

	public function render()
	{
		$this->template->setFile(__DIR__ . '/SignIn.latte');
		$this->template->render();
	}

    protected function createComponentSignInForm()
    {
		$form = new Form;
		$form->addText('usernameOrEmail')->setRequired('Please enter your username or email.');
		$form->addPassword('password')
			->setRequired('Please enter your password.');
		$form->addCheckbox('remember', 'Keep me signed in');
		$form->addSubmit('send', 'Sign in');
		$form->onSuccess[] = $this->succes;
		return $form;
    }

	public function succes($form)
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