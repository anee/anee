<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Profile extends Control
{

	/** @var \App\Model\UserBaseLogic @inject*/
	public $userBaseLogic;

	private $username;

    public function __construct(UserBaseLogic $userBaseLogic, $username)
    {
		$this->userBaseLogic = $userBaseLogic;
		$this->username = $username;
    }

	public function render()
	{
		$this->template->setFile(__DIR__ . '/Profile.latte');

		$this->template->user = $this->userBaseLogic->findOneByUsername($this->username);

		$this->template->render();
	}
}