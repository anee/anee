<?php

namespace App\Modules\BackendModule\Controls;

use App\Model\TransportBaseLogic;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;


/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchFor extends Control
{

	///** @var \App\Model\User */
	//private $user;

	/** @var \App\Model\TransportBaseLogic @inject */
    public $transportBaseLogic;

    public function __construct(TransportBaseLogic $transportBaseLogic)
    {
        $this->transportBaseLogic = $transportBaseLogic;
		//$this->user = $user;
    }

	public function render()
	{
		$this->template->setFile(__DIR__ . '/SearchFor.latte');
		$this->template->render();
	}

    protected function createComponentSearchForForm()
    {
		$form = new Form;
        $form->addText('search')->setAttribute('placeholder', 'Search...');
        $category = array(
            'Events' => 'Events',
            'Tracks' => 'Tracks',
            'Places' => 'Places',
            'Photos' => 'Photos',
        );
        $transports = array();
        //foreach($this->transportBaseLogic->findAll($this->user->getIdentity()->data['id']) as $transport) {
        //    $transports[$transport->name] = ucfirst($transport->name);
        //}
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
		$values = $form->values;
		$values['userId'] = $this->getPresenter()->user->getIdentity()->data['id'];
		$values['username'] = $this->getPresenter()->user->getIdentity()->data['username'];
        $this->presenter->redirect(':Backend:Search:default', array('values' => $values, 'username' => $values['username']));
    }
}