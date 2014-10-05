<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 9.7.14
 * Time: 19:31
 * To change this template use File | Settings | File Templates.
 */

namespace App\Modules\SecurityModule\Components;

use Nette;
use Nette\Application\UI\Form;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SignInFormFactory extends Nette\Object
{


    public function create()
    {
		$form = new Form;
		$form->addText('usernameOrEmail')->setRequired('Please enter your username or email.');
		$form->addPassword('password')
			->setRequired('Please enter your password.');
		$form->addCheckbox('remember', 'Keep me signed in');
		$form->addSubmit('send', 'Sign in');
		return $form;
    }
}