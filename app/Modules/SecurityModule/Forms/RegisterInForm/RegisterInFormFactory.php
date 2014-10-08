<?php


namespace App\Modules\SecurityModule\Components;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Form;
use Kdyby\Doctrine\EntityDao;;
use App\Model\User;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class RegisterInFormFactory extends Nette\Application\UI\Control
{

	/** @var EntityDao  */
	private $userBaseLogic;

	public function __construct(UserBaseLogic $userBaseLogic)
	{
		$this->userBaseLogic = $userBaseLogic;
	}

	public function create()
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
		$form->addSubmit('send', 'Register');
		$form->onSuccess[] = $this->succes;
		return $form;
	}

	public function succes($form)
	{
		$values = $form->getValues();

		$userByUsername = $this->userBaseLogic->findOneSignIn($values->username);
		$userByEmail = 	$this->userBaseLogic->findOneSignIn($values->email);

		if($userByEmail == NULL && $userByUsername == NULL) {
			$this->userBaseLogic->save(new User($values->username, $values->email, $values->password));
			$this->getPresenter()->redirect(':Frontend:Homepage:default');
		} else {
			$form->addError('Username or user with this email already exist.');
		}
	}
}