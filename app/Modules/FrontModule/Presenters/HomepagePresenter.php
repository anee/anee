<?php

namespace App\Modules\FrontModule\Presenters;



/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
        $this->template->event = $this->eventRepository->findLast();
        $this->template->track = $this->trackRepository->findLast();
        $this->template->track2 = $this->trackRepository->findBeforeLast();
        $this->template->photos = $this->photoRepository->findLastByCount(4);
	}
}
