<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;
use App\Model\User;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchFor extends Control
{


	private $username;

	/** @var \App\Model\UserBaseLogic @inject */
    public $userBaseLogic;

    public function __construct(UserBaseLogic $userBaseLogic)
    {
        $this->userBaseLogic = $userBaseLogic;
    }

	public function render()
	{
		$this->template->setFile(__DIR__ . '/SearchFor.latte');
		$this->template->render();
	}

    protected function createComponentSearchForForm()
    {
		$username = $this->getPresenter()->getParameter('username');
		if($username != NULL) {
			$this->username = $username;
		} elseif ($this->getPresenter()->getUser()->isLoggedIn()) {
			$this->username = $this->getPresenter()->getUser()->getIdentity()->data['username'];
		}

		$transports = array();
		foreach($this->userBaseLogic->findOneByUsername($this->username)->transports as $transport) {
			$transports[$transport->name] = ucfirst($transport->name);
		}

		$form = new Form;
        $form->addText('search')->setAttribute('placeholder', 'Search...');
        $category = array(
            'Events' => 'Events',
            'Tracks' => 'Tracks',
            'Places' => 'Places',
            'Photos' => 'Photos',
        );
        $time = array(
            '' => 'Any time',
			'Past hour' => 'Past hour',
            'Past week' => 'Past week',
            'Past month' => 'Past month',
            'Past year' => 'Past year',
        /* 'Custom range...' => 'Custom range...',*/
        );
		$sort = array(
			'' => 'DateTime'
		);
        $form->addMultiSelect('filterCategory', NULL, $category);
        $form->addMultiSelect('filterTransport', NULL, $transports);
        $form->addSelect('filterTime', NULL, $time);
		$form->addSelect('filterSortBy', NULL, $sort);
        $form->addSubmit('send', '');
        $form->onSuccess[] = $this->succes;
        return $form;
    }

    public function succes($form)
    {
        $this->presenter->redirect(':Backend:Search:default', array('values' => $form->values, 'username' => $this->username));
    }
}