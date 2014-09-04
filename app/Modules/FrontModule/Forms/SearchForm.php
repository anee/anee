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
use Instante\Bootstrap3Renderer\BootstrapRenderer;


class SearchForm extends Nette\Object
{
    public $presenter;

    public function __construct()
    {

    }

    public function create($presenter, $transports)
    {
        $this->presenter = $presenter;
        $form = new Form;
        $form->setRenderer(new BootstrapRenderer);
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
            'Cycling' => 'Cycling',
            'Running' => 'Running',
        );
        $transport_db = array();
        foreach($transports as $transport) {
            $transportTest[$transport->name] = $transport->name;
        }
        $transport = array_merge($transport_base, $transport_db);
        $time = array(
            '' => 'Any time',
			'Past hour' => 'Past hour',
            'Past week' => 'Past week',
            'Past month' => 'Past month',
            'Past year' => 'Past year',
        /* 'Custom range...' => 'Custom range...',*/
        );
        $form->addMultiSelect('filterCategory', NULL, $category);
        $form->addSelect('filterTransport', NULL, $transport);
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