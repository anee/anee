<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\UserBaseLogic;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
interface ITopMenuFactory
{

    /**
     * @return TopMenu
     */
    function create();
}

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TopMenu extends Control
{


	private $usernameUrl;

	/** @var \App\Model\UserBaseLogic */
    public $userBaseLogic;

    public function __construct(UserBaseLogic $userBaseLogic)
    {
        $this->userBaseLogic = $userBaseLogic;
    }

	public function render($file)
	{
		$this->template->setFile($file);
		$this->template->render();
	}

    protected function createComponentSearchForForm()
    {
        $user = $this->userBaseLogic->findOneByUsername($this->getPresenter()->getParameter('username'));
        if($user != NULL) {
            $this->usernameUrl = $user->usernameUrl;
        } elseif ($this->getPresenter()->getUser()->isLoggedIn()) {
            $this->usernameUrl = $this->userBaseLogic->findOneByUsername($this->getPresenter()->getUser()->getIdentity()->data['username'])->usernameUrl;
        }

		$transports = array();
		foreach($this->userBaseLogic->findOneByUsernameUrl($this->usernameUrl)->transports as $transport) {
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
        $form->onSuccess[] = $this->success;
        return $form;
    }

    public function success($form)
    {
        $this->presenter->redirect(':Backend:Search:default', array('values' => $form->values, 'username' => $this->usernameUrl));
    }
}