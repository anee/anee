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

class CommentForm extends Nette\Object
{

    public function __construct()
    {

    }

    public function create()
    {
        $form = new Form;
        $form->addText('text')->setAttribute('placeholder', 'Your view...');
        $form->addSubmit('send', '');
        $form->onSuccess[] = $this->succes;
        return $form;
    }

    public function succes($form)
    {

    }
}