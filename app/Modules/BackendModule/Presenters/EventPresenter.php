<?php

namespace App\Modules\BackendModule\Presenters;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class EventPresenter extends BasePresenter
{

	/** @var \App\Model\EventBaseLogic @inject*/
	public $eventBaseLogic;

	/** @var  \App\Model\Event */
    public $event;

    public function renderDetail($id)
    {
		$this->event = $this->eventsBaseLogic->findOneByIdAndUserId($id, $this->getUser()->getIdentity()->data['id']);

        if ($this->event == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->event = $this->event;
        }
    }
}
