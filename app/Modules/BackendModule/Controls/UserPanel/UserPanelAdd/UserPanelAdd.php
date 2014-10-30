<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class UserPanelAdd extends Control
{

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

    public function __construct(UserBaseLogic $userBaseLogic)
    {
		$this->userBaseLogic = $userBaseLogic;
    }

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->render();
	}

	/*public function handleAdd()
	{
		$this->template->showSimpleForm = true;
		if ($this->presenter->isAjax()) {
			$this->invalidateControl('simpleForm');
		}
	}*/

	/*protected function createComponentSimpleForm()
	{
		$form = new Nette\Application\UI\Form;
		$form->addText('email', 'Email:')
			->addRule(Form::FILLED, 'Zadejte email');

		$form->addSubmit('register', 'Registrovat')
			->onClick[] = callback($this, 'simpleFormSubmitted');

		return $form;
	}

	public function simpleFormSubmitted($btn)
	{
		// ... zde se zpracuj vysledky z $btn->form->getValues()
		$this->flashMessage('Vysledek byl ulozen/zpracovan.');
		if ($this->presenter->isAjax()) {
			$this->invalidateControl('simpleForm');
			$this->invalidateControl('flashMsg');
		} else {
			$this->redirect('this');
		}
	}*/
}