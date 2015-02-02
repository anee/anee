<?php

namespace App\Modules\BackendModule\Controls;

use Nette;
use Nette\Application\UI\Control;
use ViewKeeper\ViewKeeper;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface IProfileContainerFactory
{

	/**
	 * @return ProfileContainer
	 */
	function create();
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class ProfileContainer extends Control
{

	/**
	 * @var \ViewKeeper\ViewKeeper
	 */
	public $keeper;

    public function __construct(ViewKeeper $keeper)
    {
		$this->keeper = $keeper;
    }

	public function render()
	{
		$this->template->setFile($this->keeper->getView('Backend:' . $this->name, 'controls'));
		$this->template->render();
	}
}