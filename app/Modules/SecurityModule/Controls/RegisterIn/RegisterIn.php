<?php


namespace App\Modules\SecurityModule\Controls;

use App\Model\UserBaseLogic;
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
		$form->addText('username')->setRequired('Please enter your username.');
		$form->addPassword('password')
			->setRequired('Please enter your password.');
		$form->addText('email')->setRequired('Please enter your email')
				->addCondition(Form::EMAIL, 'Please insert correct email address');
		$form->addPassword('passwordRe', "Reenter your password: *")
			->addConditionOn($form['password'], Form::VALID)
			->addRule(Form::FILLED, 'Reenter your password')
			->addRule(Form::EQUAL, 'Passwords do not match', $form['password']);
		$form->addCheckbox('public', 'Public profile');
		$form->addSubmit('send', 'Register');
		$form->onSuccess[] = $this->succes;
		return $form;
	}

	public function succes($form)
	{
		$values = $form->getValues();

		if($this->userBaseLogic->findOneSignIn($values->username) == NULL && $this->userBaseLogic->findOneSignIn($values->email) == NULL) {

			$this->userBaseLogic->save(new User($values->username, $values->public, $values->email, $values->password));
			$this->getPresenter()->redirect(':Backend:Homepage:default');
		} else {
			$form->addError('Username or user with this email already exist.');
		}
	}
}