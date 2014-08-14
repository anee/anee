<?php

namespace App\Modules\FrontModule\Presenters;

use Nette;

/**
 * Homepage presenter.
 */
class EventPresenter extends BasePresenter
{

    /** @var \App\Model\EventRepository @inject*/
    public $eventRepository;

    public $event;

    public function renderDetail($id)
    {
        $this->event = $this->eventRepository->findById($id);

        if ($this->event == null) {
            throw new Nette\Application\BadRequestException;
        } else {
            $this->template->event = $this->event;
        }
    }
}
