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
        $form->addText('search')->setAttribute('placeholder', 'Search...');
        $category = array(
            'Any category',
            'Events',
            'Tracks',
            'Places',
            'Photos',
        );
        $transport = array(
            'Any transport',
            'By cycle',
            'By run',
        );
        $time = array(
            'Any time',
			'Past hour',
			'Past week',
			'Past month',
            'Past year',
			'Custom range...',
        );
        $form->addSelect('filterCategory', NULL, $category);
        $form->addSelect('filterTransport', NULL, $category);
        $form->addSelect('filterTime', NULL, $category);
        $form->addSubmit('send', '');
        $form->onSuccess[] = $this->processForm;
        return $form;
    }

    public function processForm($form)
    {
        $this->presenter->redirect(':Front:Search:default', array('values' => $form->values));
    }
}