<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 9.7.14
 * Time: 19:31
 * To change this template use File | Settings | File Templates.
 */

namespace App\Modules\BackendModule\Forms;

use App\Model\TransportBaseLogic;
use Nette;
use Nette\Application\UI\Form;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class SearchFormFactory extends Nette\Object
{

    private $presenter;

	private $user;

	/** @var TransportBaseLogic */
    private $transportBaseLogic;

    public function __construct(TransportBaseLogic $transportBaseLogic)
    {
        $this->transportBaseLogic = $transportBaseLogic;
    }

    public function create($parent, $user)
    {
        $this->presenter = $parent;
		$this->user = $user;

        $form = new Form;
        $form->addText('search')->setAttribute('placeholder', 'Search...');
        $category = array(
            'Events' => 'Events',
            'Tracks' => 'Tracks',
            'Places' => 'Places',
            'Photos' => 'Photos',
        );
        $transports = array();
        foreach($this->transportBaseLogic->findAll($this->user->getIdentity()->data['id']) as $transport) {
            $transports[$transport->name] = ucfirst($transport->name);
        }
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
		$values['userId'] = $this->user->getIdentity()->data['id'];
        $this->presenter->redirect(':Backend:Search:default', array('values' => $values, 'username' => $this->user->getIdentity()->data['username']));
    }
}