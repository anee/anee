<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use App\Model\User;
use Nette\Mail\SendmailMailer;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IFeedbackModal
{

	/**
	 * @param User $loggedUser
	 * @return FeedbackModal
	 */
	function create(User $loggedUser);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class FeedbackModal extends Control
{

	/** @var User */
	private $loggedUser;


	public function __construct(User $loggedUser)
	{
		$this->loggedUser = $loggedUser;
	}

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}

	protected function createComponentFeedbackForm()
	{
		$form = new Form;
		$form->addText('subject')->setAttribute('placeholder', 'Subject')->setRequired();
		$form->addTextArea('message')->setAttribute('placeholder', 'Message ...')->setRequired();
		$form->addSubmit('save', 'send');
		$form->onSuccess[] = $this->success;

		return $form;
	}

	public function success($form)
	{
		if($this->getPresenter()->IsAjax()) {
			$values = $form->getValues();

			$user = $this->loggedUser;

			$mail = new Nette\Mail\Message();
			$mail->setFrom($user->email)
				->addTo('L.Drahnik@gmail.com')					// TODO: create new email address
				->setSubject($values['subject'])
				->setBody($values['message'] ."\n\n\nUser: ".$user->username);

			$mailer = new SendmailMailer;
			$mailer->send($mail);

			$this->getPresenter()->redirect('this');
		}
	}
}