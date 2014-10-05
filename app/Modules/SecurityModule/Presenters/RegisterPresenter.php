<?php

namespace App\Modules\SecurityModule\Presenters;

use App\Modules\SecurityModule\Components\TInjectRegisterInFormFactory;
use Nette;
use App\Model;


class RegisterPresenter extends BasePresenter
{

	use TInjectRegisterInFormFactory;

    public function formatLayoutTemplateFiles()
    {
        $files = parent::formatLayoutTemplateFiles();
        $files[] = __DIR__ . '/../templates/@layoutSign.latte';

        return $files;
    }

	/**
	 * @return \App\Modules\SecurityModule\Components\RegisterInFormFactory
	 */
	protected function createComponentRegisterInFormFactory()
	{
		return $this->registerInFormFactory->create($this);
	}

	/*public function registerInFormSucceeded($form)
	{
		$user = $this->
        /*$values = $form->getValues();

		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}
		try {
			$this->getUser()->login($values->userNameOrEmail, $values->password);
			$this->redirect(':Front:Homepage:default');

		} catch (AuthenticationException $e) {
 			$form->addError($e->getMessage());
		}
	}*/
}
