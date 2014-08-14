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

    public function create($presenter)
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
        $transport = array(
            '' => 'Any transport',
            'By cycle' => 'By cycle',
            'By run' => 'By run',
        );
        $time = array(
            '' => 'Any time',
			'Past hour' => 'Past hour',
            'Past week' => 'Past week',
            'Past month' => 'Past month',
            'Past year' => 'Past year',
        /* 'Custom range...' => 'Custom range...',*/
        );
        $form->addSelect('filterCategory', NULL, $category);
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