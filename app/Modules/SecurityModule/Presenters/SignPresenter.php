<?php

namespace App\Modules\LoginModule\Presenters;

use App\Modules\SecurityModule\Presenters\BasePresenter;
use Nette;
use Nette\Application\UI\Form;
use App\Model;
use Nette\Security\AuthenticationException;



class SignPresenter extends BasePresenter
{


    public function formatLayoutTemplateFiles()
    {
        $files = parent::formatLayoutTemplateFiles();
        $files[] = __DIR__ . '/../templates/@layoutSign.latte';

        return $files;
    }


    protected function createComponentSignInForm()
	{
		$form = new Form;

		$form->addText('username')->setRequired('Please enter your username.');
        $form->addText('email')->setRequired('Please enter your email.')
            ->addRule(Form::EMAIL, 'Please insert correct email address.');
		$form->addPassword('password')
			->setRequired('Please enter your password.');
		$form->addCheckbox('remember', 'Keep me signed in');
		$form->addSubmit('send', 'Sign in');
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
			$this->getUser()->login($values->username, $values->email, $values->password);
			$this->redirect(':Front:Homepage:default');

		} catch (AuthenticationException $e) {
 			$form->addError($e->getMessage());
		}
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->redirect(':Front:Sign:in');
	}
}
