<?php


namespace App\Modules\SecurityModule\Controls;

use App\Model\UserBaseLogic;
use Kdyby\Doctrine\DuplicateEntryException;
use Nette;
use Nette\Application\UI\Form;;
use App\Model\User;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class RegisterIn extends Nette\Application\UI\Control
{

	/** @var \App\Model\UserBaseLogic @inject */
	public $userBaseLogic;

	public function __construct(UserBaseLogic $userBaseLogic)
	{
		$this->userBaseLogic = $userBaseLogic;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/RegisterIn.latte');
		$this->template->render();
	}

	protected function createComponentRegisterInForm()
	{
		$form = new Form;
		$form->addText('username')->setRequired('Please enter your username.')
			->setAttribute('placeholder', 'Username');
		$form->addText('forename')->setRequired('Please enter your forename.')
			->setAttribute('placeholder', 'Forename');
		$form->addText('surname')->setRequired('Please enter your surname.')
			->setAttribute('placeholder', 'Surname');
		$form->addPassword('password')
			->setRequired('Please enter your password.')
			->setAttribute('placeholder', 'Password');
		$form->addText('email')->setRequired('Please enter your email')
			->setAttribute('placeholder', 'E-mail')
			->addCondition(Form::EMAIL, 'Please insert correct email address');
		$form->addPassword('passwordRe', "Reenter your password: *")
			->setAttribute('placeholder', 'Password re')
			->addConditionOn($form['password'], Form::VALID)
			->addRule(Form::FILLED, 'Reenter your password')
			->addRule(Form::EQUAL, 'Passwords do not match', $form['password']);
		$form->addCheckbox('public', 'Public profile');
		$form->addSubmit('send', 'Register');
		$form->onSuccess[] = $this->success;
		return $form;
	}

	public function success($form)
	{
		try {
			$values = $form->getValues();
			$this->userBaseLogic->save(new User($values->username, $values->forename, $values->surname, $values->public, $values->email, $values->password));
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} catch(DuplicateEntryException $e) {
			$form->addError('User with this username or email already exist.');
		}
	}
}