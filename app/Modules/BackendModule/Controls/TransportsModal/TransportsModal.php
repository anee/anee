<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\Transport;
use App\Model\TransportBaseLogic;
use App\Model\UserBaseLogic;
use App\Model\TrackBaseLogic;
use Nette;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use App\Model\User;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TransportsModal extends Control
{

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

	/** @var \App\Model\TransportBaseLogic @inject */
	public $transportBaseLogic;

	/** @var \App\Model\TrackBaseLogic @inject */
	public $trackBaseLogic;

	/** @var \App\Model\User */
	private $loggedUser;

	/** @var \App\Model\User */
	private $profileUser;

	public function __construct(TrackBaseLogic $trackBaseLogic,  UserBaseLogic $userBaseLogic, TransportBaseLogic $transportBaseLogic, User $profileUser, User $loggedUser)
	{
		$this->trackBaseLogic = $trackBaseLogic;
		$this->profileUser = $profileUser;
		$this->userBaseLogic = $userBaseLogic;
		$this->transportBaseLogic = $transportBaseLogic;
		$this->loggedUser = $loggedUser;
	}

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->render();
	}

	protected function createComponentTransportsForm()
	{
		$form = new Form;
		foreach($this->profileUser->transports as $transport) {
			$form->addText($transport->name)->setRequired('Please enter name.');
		}
		$form->addSubmit('save', 'save');
		$form->onSuccess[] = $this->success;

		$transports = array();
		foreach($this->profileUser->transports as $transport) {
			$transports[$transport->name] = $transport->name;
		}
		$form->setDefaults($transports);

		return $form;
	}

	public function success($form)
	{
		$values = $form->getValues();

		if ($this->getPresenter()->isAjax()) {
			foreach ($this->loggedUser->transports as $transport) {
				if($transport->name != $values[$transport->name]) {
					$transport->name = $values[$transport->name];
					$this->transportBaseLogic->save($transport);
					//$this->flashMessage('Renamed'.$transport->name.' => '.$values[$transport->name]);
				}
			}
			$this->getPresenter()->redirect('this');
		}
	}

	public function handleRemove($id)
	{
		if ($this->getPresenter()->isAjax()) {
			$this->transportBaseLogic->remove($id);

			//$this->flashMessage('Removed '.$transport->name.'.');
			$this->getPresenter()->redirect('this');
		}
	}

	protected function createComponentAddTransportForm()
	{
		$form = new Form;
		$form->addText('name')->setRequired('Please enter name.')
			->setAttribute('placeholder', 'Transport name...');
		$form->addSubmit('add', 'add');
		$form->onSuccess[] = $this->addTransport;

		return $form;
	}

	public function addTransport($form)
	{
		$values = $form->getValues();

		if ($this->getPresenter()->isAjax()) {
			$this->transportBaseLogic->save(new Transport($values['name'], $this->loggedUser));
			$this->getPresenter()->redirect('this');
		}
	}
}