<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TopTopMenu extends Control
{


    public function __construct()
    {

    }

	public function render()
	{
		$this->template->setFile(__DIR__ . '/TopTopMenu.latte');
		$this->template->render();
	}
}