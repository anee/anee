<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class ProfileContainer extends Control
{

	private $username;

    public function __construct($username)
    {
		$this->username = $username;
    }

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->components = $this->components;
		$this->template->render();
	}
}