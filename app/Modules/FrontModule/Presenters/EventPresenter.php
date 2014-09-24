<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class EventPresenter extends BasePresenter
{

	/** @var  \App\Model\Event */
    public $event;

    public function renderDetail($id)
    {
        $this->event = $this->eventBaseLogic->findById($id);

        if ($this->event == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->event = $this->event;
        }
    }
}
