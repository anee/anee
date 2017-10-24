<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\Role;
use App\Model\RoleBaseLogic;
use App\Model\UserBaseLogic;
use App\Model\TrackBaseLogic;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use App\Model\User;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IUserRolesModalFactory
{

	/**
	 * @param User $profileUser
	 * @param User $loggedUser
	 * @return TransportsModal
	 */
	function create(User $profileUser, User $loggedUser = NULL);
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class UserRolesModal extends Control
{

	/**
	 * @var \App\Model\UserBaseLogic
	 */
	public $userBaseLogic;

	/**
	 * @var \App\Model\TrackBaseLogic
	 */
	public $trackBaseLogic;

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

    /**
     * @var RoleBaseLogic
     */
	public $roleBaseLogic;

	/**
	 * @var \App\Model\User
	 */
	private $loggedUser;

	/**
	 * @var \App\Model\User
	 */
	private $profileUser;

	public function __construct(User $profileUser, User $loggedUser = NULL, ViewKeeper $keeper, TrackBaseLogic $trackBaseLogic, RoleBaseLogic $roleBaseLogic, UserBaseLogic $userBaseLogic)
	{
		$this->keeper = $keeper;
		$this->trackBaseLogic = $trackBaseLogic;
		$this->roleBaseLogic = $roleBaseLogic;
		$this->profileUser = $profileUser;
		$this->userBaseLogic = $userBaseLogic;
		$this->loggedUser = $loggedUser;
	}

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . 'UserRolesModal', 'controls'));
		$this->template->profileUser = $this->profileUser;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->roles = $this->roleBaseLogic->findAll();
		//$this->template->userBaseLog
		$this->template->render();
	}

	protected function createComponentUserRolesForm()
	{
		$form = new Form;

		$roles = $this->roleBaseLogic->findAll();
		foreach($roles as $role) {
		    /** @var $role Role */
			if(!$role->isDefaultOne()) {
				$form->addText($role->getName())->setRequired('Please enter name.');
			} else {
                $form->addText($role->getName())->setRequired('Please enter name.')->setDisabled();
            }
		}
		if(count($roles) > 2) {
			$form->addSubmit('save', 'save');
			$form->onSuccess[] = $this->success;
		}

		$rolesDefaults = array();
        foreach($roles as $role) {
            $rolesDefaults[$role->getName()] = $role->getName();
		}
		$form->setDefaults($rolesDefaults);

		return $form;
	}

	public function success($form)
	{
		$values = $form->getValues();

		if ($this->getPresenter()->isAjax()) {
            $roles = $this->roleBaseLogic->findAll();
			foreach ($roles as $role) {
                /** @var $role Role */
				if($role->getName() != $values[$role->getName()]) {
                    $role->setName($values[$role->name]);
					$this->roleBaseLogic->save($role);
				}
			}
			$this->getPresenter()->redirect('this');
		}
	}

    public function handleRemove($id) {
        if ($this->getPresenter()->isAjax()) {

            $this->roleBaseLogic->remove($id);

            $this->getPresenter()->redirect('this');
        }
    }

	protected function createComponentAddUserRoleForm()
	{
		$form = new Form;
		$form->addText('name')->setRequired('Please enter name.')
			->setAttribute('placeholder', 'Role name...');
		$form->addSubmit('add', 'add');
		$form->onSuccess[] = $this->addRole;

		return $form;
	}

	public function addRole($form)
	{
		if ($this->getPresenter()->isAjax()) {

			$values = $form->getValues();

			$role = $this->roleBaseLogic->findOneByName($values->name);
			if ($role == NULL) {
				$this->roleBaseLogic->save(new Role($values->name));
				$this->getPresenter()->redirect('this');
			}
		}
	}
}