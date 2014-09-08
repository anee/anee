<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lukas
 * Date: 9.7.14
 * Time: 19:31
 * To change this template use File | Settings | File Templates.
 */

namespace App\Modules\FrontModule\Forms;

use Nette;
use Nette\Application\UI\Form;
use Kdyby\Doctrine\EntityDao;


class SearchFormFactory extends Nette\Object
{

    private $presenter;
    private $transport;

    public function __construct(EntityDao $dao)
    {
        $this->transport = $dao;
    }

    public function create($parent)
    {
        $this->presenter = $parent;

        $form = new Form;
        $form->addText('search')->setAttribute('placeholder', 'Search...');
        $category = array(
            '' => 'Any category',
            'Events' => 'Events',
            'Tracks' => 'Tracks',
            'Places' => 'Places',
            'Photos' => 'Photos',
        );
        $transport_base = array(
            '' => 'Any transport',
        );
        $transport_doctrine = array();
        foreach($this->transport->findAll() as $transport) {
            $transport_doctrine[$transport->name] = $transport->name;
        }
        $transport = array_merge($transport_base, $transport_doctrine);
        $time = array(
            '' => 'Any time',
			'Past hour' => 'Past hour',
            'Past week' => 'Past week',
            'Past month' => 'Past month',
            'Past year' => 'Past year',
        /* 'Custom range...' => 'Custom range...',*/
        );
        $form->addMultiSelect('filterCategory', NULL, $category);
        $form->addMultiSelect('filterTransport', NULL, $transport);
        $form->addSelect('filterTime', NULL, $time);
        $form->addSubmit('send', '');
        $form->onSuccess[] = $this->succes;
        return $form;
    }

    public function succes($form)
    {
        $this->presenter->redirect('Search:default', array('values' => $form->values));
    }
}